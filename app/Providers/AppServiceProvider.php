<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
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

            // Popular products
            $popularProducts = Cache::remember('popular-products', 3600, function () {
                return Product::where('status', 'active')
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
            });

            // Get cart data from session
            $cart = session('cart', []);
            $cartCount = collect($cart)->sum('quantity');
            $cartSubtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            // Favorites
            $favorites = session('favorites', []);
            $favoritesCount = count($favorites);

            // Product filters data
            $minPrice = Cache::remember('min-price', 3600, function () {
                return Product::min('price');
            });

            $maxPrice = Cache::remember('max-price', 3600, function () {
                return Product::max('price');
            });

            $colors = Cache::remember('available-colors', 3600, function () {
                return Product::active()
                    ->get()
                    ->pluck('available_colors')
                    ->flatten()
                    ->unique()
                    ->values()
                    ->toArray();
            });

            $brands = Cache::remember('available-brands', 3600, function () {
                return Product::whereNotNull('brand')
                    ->where('brand', '!=', '')
                    ->distinct()
                    ->pluck('brand')
                    ->toArray();
            });

            // Current filter values from request
            $currentFilters = [
                'sort' => Request::get('sort', 'newest'),
                'category' => Request::get('category'),
                'brand' => (array)Request::get('brand', []),
                'color' => (array)Request::get('color', []),
                'min_price' => Request::get('min_price', $minPrice),
                'max_price' => Request::get('max_price', $maxPrice)
            ];

            // Share with all views
            $view->with([
                'categories' => $categories,
                'popularProducts' => $popularProducts,
                'cart' => $cart,                     // Cart items array
                'cartCount' => $cartCount,            // Total items in cart
                'cartSubtotal' => $cartSubtotal,      // Cart subtotal amount
                'favorites' => $favorites,
                'favoritesCount' => $favoritesCount,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'colors' => $colors,
                'brands' => $brands,
                'currentFilters' => $currentFilters
            ]);
        });

        Route::aliasMiddleware('admin', AdminMiddleware::class);
    }
}
