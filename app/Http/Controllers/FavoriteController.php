<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');
        $favorites = $this->getFavoritesFromSession();

        if (array_key_exists($productId, $favorites)) {
            unset($favorites[$productId]);
            $action = 'removed';
            $message = 'Product removed from favorites';
        } else {
            $product = Product::findOrFail($productId);
            $favorites[$productId] = $this->formatProductData($product);
            $action = 'added';
            $message = 'Product added to favorites';
        }

        $this->updateFavoritesInSession($favorites);

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'favorites_count' => count($favorites)
        ]);
    }

    public function listFavorites()
    {
        $favorites = $this->getFavoritesFromSession();

        return response()->json([
            'success' => true,
            'favorites' => array_values($favorites),
            'count' => count($favorites)
        ]);
    }

    public function getFavoritesCount()
    {
        return response()->json([
            'success' => true,
            'count' => count($this->getFavoritesFromSession())
        ]);
    }

    private function getFavoritesFromSession()
    {
        return session('favorites', []);
    }

    private function updateFavoritesInSession($favorites)
    {
        session(['favorites' => $favorites]);
    }

    private function formatProductData(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->current_price,
            'image_url' => $product->image_url,
            'brand' => $product->brand->name ?? 'Unknown',
            'created_at' => now()->toDateTimeString()
        ];
    }
}
