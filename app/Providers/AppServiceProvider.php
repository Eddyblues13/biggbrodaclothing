<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
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

            // Session values
            $cartCount = session('cart') ? count(session('cart')) : 0;
            $cartSubtotal = session('cart') ? collect(session('cart'))->sum('subtotal') : 0;
            $favorites = session('favorites', []);
            $favoritesCount = count($favorites);

            // Share with all views
            $view->with([
                'categories' => $categories,
                'popularProducts' => $popularProducts,
                'cartCount' => $cartCount,
                'cartSubtotal' => $cartSubtotal,
                'favorites' => $favorites,
                'favoritesCount' => $favoritesCount,
            ]);
        });

        Route::aliasMiddleware('admin', AdminMiddleware::class);
    }
}
