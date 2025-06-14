<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->active()
            ->with(['galleries' => fn($q) => $q->ordered()]);

        // Filter by category if specified
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by search term
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sortOptions = [
            'newest' => ['created_at', 'desc'],
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'popular' => ['is_bestseller', 'desc']
        ];

        $sort = $request->get('sort', 'newest');
        [$sortField, $sortDirection] = $sortOptions[$sort] ?? $sortOptions['newest'];

        $products = $query->orderBy($sortField, $sortDirection)
            ->paginate(12)
            ->appends($request->query());

        return view('products.index', [
            'products' => $products,
            'categories' => Category::active()->get(),
            'selectedCategory' => $request->category,
            'sort' => $sort
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {

        // Eager load necessary relationships
        $product = Product::with('category', 'galleries')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Get related products (from the same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->bestsellerOrFeatured()
            ->orderByPopularity()
            ->limit(4)
            ->get();

        return view('home.view_product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * Display featured products (for homepage).
     */
    public function featured()
    {
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return response()->json($featuredProducts);
    }

    /**
     * Display bestseller products.
     */
    public function bestsellers()
    {
        $bestsellers = Product::with('category')
            ->active()
            ->bestsellers()
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return response()->json($bestsellers);
    }

    public function filter(Request $request)
    {
        try {
            $query = Product::active()->withMainImage();

            // Apply filters
            if ($request->category) {
                $query->where('category_id', $request->category);
            }

            if ($request->min_price && $request->max_price) {
                $query->whereBetween('price', [
                    floatval($request->min_price),
                    floatval($request->max_price)
                ]);
            }

            if ($request->colors) {
                $colors = is_array($request->colors) ? $request->colors : explode(',', $request->colors);
                $query->where(function ($q) use ($colors) {
                    foreach ($colors as $color) {
                        $q->orWhere('color', 'like', "%{$color}%");
                    }
                });
            }

            if ($request->brands) {
                $brands = is_array($request->brands) ? $request->brands : explode(',', $request->brands);
                $query->whereIn('brand', $brands);
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
                $html .= view('products.partials.product', ['product' => $product])->render();
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $products->total(),
                'pagination' => $products->links()->toHtml()
            ]);
        } catch (\Exception $e) {
            Log::error('Filter error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
