<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    public function index()
    {
        try {
            // Cache categories for 1 hour
            // $categories = Cache::remember('homepage-categories', 3600, function () {
            //     return Category::where('is_active', true)
            //         ->withCount(['products' => fn($q) => $q->where('status', 'active')])
            //         ->with([
            //             'products' => fn($q) => $q
            //                 ->where('status', 'active')
            //                 ->orderBy('created_at', 'desc')
            //                 ->take(1)
            //                 ->with('galleries') // Eager load galleries
            //         ])
            //         ->orderBy('created_at')
            //         ->get();
            // });

            $categories = Category::with(['products.galleries'])->active()->get();




            // Get popular products (active, bestseller or featured)
            $popularProducts = Product::where('status', 'active')
                ->where(function ($query) {
                    $query->where('is_bestseller', true)
                        ->orWhere('is_featured', true);
                })
                ->with(['category', 'galleries' => function ($q) {
                    $q->where('is_default', true)
                        ->orWhere('position', 0);
                }])
                ->orderBy('is_bestseller', 'desc')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();


            $featuredProducts = Product::active()
                ->featured()
                ->with('category') // Optional: if you need category data
                ->take(4)
                ->get();

            // Get cart data from session
            $cartCount = $this->getCartCount();
            $cartSubtotal = $this->getCartSubtotal();

            // Get favorites count from session
            $favoritesCount = $this->getFavoritesCount();

            // Get favorites from session
            $favorites = session('favorites', []);

            return view('home.homepage', compact(
                'categories',
                'popularProducts',
                'cartCount',
                'cartSubtotal',
                'favoritesCount',
                'favorites',
                'featuredProducts'
            ));
        } catch (\Exception $e) {
            Log::error('Homepage loading error: ' . $e->getMessage());

            // Fallback data for error page
            $fallbackCategories = Category::where('is_active', true)->get();
            $fallbackCartCount = $this->getCartCount();
            $fallbackFavoritesCount = $this->getFavoritesCount();

            if (!app()->environment('production')) {
                return view('errors.development', [
                    'error' => $e,
                    'categories' => $fallbackCategories,
                    'cartCount' => $fallbackCartCount,
                    'favoritesCount' => $fallbackFavoritesCount
                ]);
            }

            return view('errors.homepage', [
                'categories' => $fallbackCategories,
                'cartCount' => $fallbackCartCount,
                'favoritesCount' => $fallbackFavoritesCount
            ]);
        }
    }


    public function shop(Request $request)
    {
        try {
            // Cache categories for 1 hour
            $categories = Cache::remember('homepage-categories', 3600, function () {
                return Category::where('is_active', true)
                    ->with(['products' => function ($query) {
                        $query->where('status', 'active')
                            ->with(['galleries' => function ($q) {
                                $q->where('is_default', true)
                                    ->orWhere('position', 0);
                            }]);
                    }])
                    ->orderBy('created_at')
                    ->get();
            });

            // Get popular products (active, bestseller or featured)
            $popularProducts = Product::where('status', 'active')
                ->where(function ($query) {
                    $query->where('is_bestseller', true)
                        ->orWhere('is_featured', true);
                })
                ->with(['category', 'galleries' => function ($q) {
                    $q->where('is_default', true)
                        ->orWhere('position', 0);
                }])
                ->orderBy('is_bestseller', 'desc')
                ->orderBy('is_featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();

            // Get cart data from session
            $cartCount = $this->getCartCount();
            $cartSubtotal = $this->getCartSubtotal();

            // Get favorites count from session
            $favoritesCount = $this->getFavoritesCount();

            // Get favorites from session
            $favorites = session('favorites', []);














            $query = Product::active()->withMainImage();

            // Filters
            if ($request->filled('category') && $request->category !== 'all') {
                $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
            }
            if ($request->filled('price')) {
                foreach ($request->price as $range) {
                    if ($range === '0-300000') $query->orWhereBetween('price', [0, 300000]);
                    if ($range === '300000-600000') $query->orWhereBetween('price', [300000, 600000]);
                    if ($range === '600000-1000000') $query->orWhereBetween('price', [600000, 1000000]);
                    if ($range === '1000000+') $query->orWhere('price', '>=', 1000000);
                }
            }
            if ($request->filled('size')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->size as $size) {
                        $q->orWhere('size', 'like', "%{$size}%");
                    }
                });
            }

            // Sorting
            switch ($request->get('sort')) {
                case 'price-low':
                    $query->orderBy('price');
                    break;
                case 'price-high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name');
                    break;
                default:
                    $query->orderByPopularity();
            }

            $perPage = 12;
            $products = $query->paginate($perPage)->withQueryString();

            $categories = Category::orderBy('name')->get();
            $sizes = Product::getAvailableSizes();

            return view('home.shop', compact(
                'categories',
                'popularProducts',
                'cartCount',
                'cartSubtotal',
                'favoritesCount',
                'favorites',
                'products',
                'categories',
                'sizes'
            ));
        } catch (\Exception $e) {
            Log::error('Homepage loading error: ' . $e->getMessage());

            // Fallback data for error page
            $fallbackCategories = Category::where('is_active', true)->get();
            $fallbackCartCount = $this->getCartCount();
            $fallbackFavoritesCount = $this->getFavoritesCount();

            if (!app()->environment('production')) {
                return view('errors.development', [
                    'error' => $e,
                    'categories' => $fallbackCategories,
                    'cartCount' => $fallbackCartCount,
                    'favoritesCount' => $fallbackFavoritesCount
                ]);
            }

            return view('errors.homepage', [
                'categories' => $fallbackCategories,
                'cartCount' => $fallbackCartCount,
                'favoritesCount' => $fallbackFavoritesCount
            ]);
        }
    }

    protected function getCartCount()
    {
        return count(session('cart', []));
    }

    protected function getCartSubtotal()
    {
        return collect(session('cart', []))->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    protected function getFavoritesCount()
    {
        return count(session('favorites', []));
    }

    public function filterByColor($color)
    {
        $products = Product::active()
            ->get()
            ->filter(function ($product) use ($color) {
                return in_array(strtolower($color), array_map('strtolower', $product->available_colors));
            });

        return view('home.collections', compact('products', 'color'));
    }



    public function collections(Request $request)
    {
        $query = Product::active()->withMainImage();

        // Apply filters from request
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->brand) {
            $query->whereIn('brand', (array)$request->brand);
        }

        if ($request->color) {
            $query->where(function ($q) use ($request) {
                foreach ((array)$request->color as $color) {
                    $q->orWhere('color', 'like', "%{$color}%");
                }
            });
        }

        if ($request->min_price && $request->max_price) {
            $query->whereBetween('price', [
                $request->min_price,
                $request->max_price
            ]);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'bestsellers':
                $query->bestsellers();
                break;
            case 'featured':
                $query->featured();
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('home.collections', compact('products'))->render(),
                'count' => $products->total(),
                'pagination' => $products->links()->toHtml()
            ]);
        }

        return view('home.collections', compact('products'));
    }

    public function filterByBrand($brand)
    {
        $products = Product::where('brand', $brand)->visible()->get();
        return view('home.collections', compact('products', 'brand'));
    }


    // ProductController.php
    public function filter(Request $request)
    {
        $query = Product::active()->withMainImage();

        // Apply filters
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->min_price && $request->max_price) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        if ($request->colors) {
            $query->where(function ($q) use ($request) {
                foreach ($request->colors as $color) {
                    $q->orWhere('color', 'like', "%{$color}%");
                }
            });
        }

        if ($request->brands) {
            $query->whereIn('brand', $request->brands);
        }

        // Apply sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'bestsellers':
                $query->bestsellers();
                break;
            case 'featured':
                $query->featured();
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        $html = '';
        foreach ($products as $product) {
            $html .= '
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="single-product-wrapper">
                    <div class="product-img">
                        <img src="' . $product->thumbnail_url . '" alt="' . $product->name . '">' .
                ($product->gallery_urls ? '<img class="hover-img" src="' . ($product->gallery_urls[0] ?? $product->image_url) . '" alt="">' : '') .
                ($product->is_on_sale ? '<div class="product-badge offer-badge"><span>-' . $product->discount_percentage . '%</span></div>' : '') .
                ($product->is_new ? '<div class="product-badge new-badge"><span>New</span></div>' : '') . '
                        <div class="product-favourite">
                            <a href="#" class="favme fa fa-heart"></a>
                        </div>
                    </div>
    
                    <div class="product-description">
                        <span>' . $product->brand . '</span>
                        <a href="' . route('products.show', $product->slug) . '">
                            <h6>' . $product->name . '</h6>
                        </a>
                        <p class="product-price">' .
                ($product->is_on_sale ? '<span class="old-price">$' . number_format($product->price, 2) . '</span>' : '') . '
                            $' . number_format($product->current_price, 2) . '
                        </p>
    
                        <div class="hover-content">
                            <div class="add-to-cart-btn">
                                <a href="#" class="btn essence-btn add-to-cart" data-product-id="' . $product->id . '">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        return response()->json([
            'html' => $html,
            'count' => $products->total(),
            'pagination' => $products->links()->toHtml()
        ]);
    }



    public function addSubscribers(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create subscriber
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing!'
        ]);
    }
}
