<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Add product to cart with variations
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);
        $size = $request->input('size', '');
        $color = $request->input('color', '');

        // Check stock availability
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        $cart = session()->get('cart', []);
        $cartKey = $this->generateCartKey($product->id, $size, $color);

        if (isset($cart[$cartKey])) {
            // Update existing item
            $newQuantity = $cart[$cartKey]['quantity'] + $quantity;

            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more than available stock'
                ], 400);
            }

            $cart[$cartKey]['quantity'] = $newQuantity;
            $message = 'Product quantity updated in cart';
        } else {
            // Add new item
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->current_price,
                "image" => $product->thumbnail_url,
                "slug" => $product->slug,
                "brand" => $product->brand->name ?? 'Unknown',
                "size" => $size,
                "color" => $color,
                "stock" => $product->stock,
                "delivery_date" => now()->addDays(rand(3, 7))->format('M d')
            ];
            $message = 'Product added to cart successfully';
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $this->getCartCount(),
            'cart_subtotal' => $this->getCartSubtotal()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'change' => 'required|integer'
        ]);

        $cartKey = $request->cart_key;
        $change = $request->change;
        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }

        $item = $cart[$cartKey];
        $product = Product::find($item['product_id']);
        $newQuantity = $item['quantity'] + $change;

        // Validate stock
        if ($product && $newQuantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot exceed available stock'
            ], 400);
        }

        if ($newQuantity < 1) {
            unset($cart[$cartKey]);
            $message = 'Product removed from cart';
        } else {
            $cart[$cartKey]['quantity'] = $newQuantity;
            $message = 'Cart quantity updated successfully';
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $this->getCartCount(),
            'cart_subtotal' => $this->getCartSubtotal(),
            'item_removed' => ($newQuantity < 1)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string'
        ]);

        $cartKey = $request->cart_key;
        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        unset($cart[$cartKey]);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $this->getCartCount(),
            'cart_subtotal' => $this->getCartSubtotal()
        ]);
    }

    /**
     * Get cart data for AJAX updates
     */
    public function getCartData()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->getCartSubtotal();
        $shipping = $subtotal > 100 ? 0 : 10;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $tax + $shipping;

        $formattedCart = [];
        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);
            $formattedCart[$key] = [
                'id' => $key,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image' => $item['image'],
                'size' => $item['size'],
                'color' => $item['color'],
                'delivery_date' => $item['delivery_date'],
                'product' => $product ? [
                    'slug' => $product->slug,
                    'stock' => $product->stock,
                    'price' => $product->price,
                    'discount_percentage' => $product->discount_percentage
                ] : null
            ];
        }

        return response()->json([
            'success' => true,
            'cart_items' => $formattedCart,
            'cart_count' => $this->getCartCount(),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    // Helper methods
    private function generateCartKey($productId, $size, $color)
    {
        return md5($productId . $size . $color);
    }

    private function getCartCount()
    {
        return array_reduce(session('cart', []), function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    private function getCartSubtotal()
    {
        return array_reduce(session('cart', []), function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    // Get cleaned cart data
    public function index()
    {
        return view('home.view_cart');
    }

    // Validate cart items
    private function validateCartItems($cart)
    {
        return collect($cart)->filter(function ($item) {
            return isset($item['product_id']) &&
                Product::find($item['product_id']);
        })->toArray();
    }

    // Calculate subtotal from validated cart
    private function calculateSubtotal($cart)
    {
        return collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }
}
