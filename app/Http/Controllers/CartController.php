<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Add product to cart
     */ 
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        // If product already exists in cart, update quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $message = 'Product quantity updated in cart';
        } else {
            // Add new product to cart
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->current_price, // Use current_price to account for discounts
                "image" => $product->image_url,
                "slug" => $product->slug,
                "brand" => $product->brand->name ?? 'Unknown'
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
            'product_id' => 'required|exists:products,id',
            'change' => 'required|integer' // Can be positive or negative
        ]);

        $productId = $request->input('product_id');
        $change = $request->input('change');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $change;

            // Remove item if quantity is less than 1
            if ($newQuantity < 1) {
                unset($cart[$productId]);
                $message = 'Product removed from cart';
            } else {
                $cart[$productId]['quantity'] = $newQuantity;
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

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => $this->getCartCount(),
                'cart_subtotal' => $this->getCartSubtotal()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    /**
     * Clear the entire cart
     */
    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0,
            'cart_subtotal' => 0
        ]);
    }

    /**
     * Get cart data for display
     */
    public function getCartData()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->getCartSubtotal();

        // Calculate discount (example: 10% discount if subtotal > 100)
        $discount = 0;
        if ($subtotal > 100) {
            $discount = $subtotal * 0.1;
        }

        $total = $subtotal - $discount;

        return response()->json([
            'success' => true,
            'cart_items' => $cart,
            'cart_count' => $this->getCartCount(),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ]);
    }

    /**
     * Get cart count (total items in cart)
     */
    private function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_reduce($cart, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    /**
     * Get cart subtotal
     */
    private function getCartSubtotal()
    {
        $cart = session()->get('cart', []);
        return array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    /**
     * Get cart content for views
     */
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->getCartSubtotal();

        // Calculate discount
        $discount = 0;
        if ($subtotal > 100) {
            $discount = $subtotal * 0.1;
        }

        $total = $subtotal - $discount;

        return view('cart.view', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'cartCount' => $this->getCartCount()
        ]);
    }
}
