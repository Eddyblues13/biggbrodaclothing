<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index()
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

            return view('home.homepage', compact(
                'categories',
                'popularProducts',
                'cartCount',
                'cartSubtotal',
                'favoritesCount',
                'favorites'
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
}
