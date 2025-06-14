<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);
        $size = $request->input('size', '');

        // Check stock availability
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        $cart = session()->get('cart', []);
        $cartKey = $this->generateCartKey($product->id, $size);

        if (isset($cart[$cartKey])) {
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
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->current_price,
                "image" => $product->image_url,
                "slug" => $product->slug,
                "size" => $size,
                "stock" => $product->stock,
            ];
            $message = 'Product added to cart successfully';
        }

        session()->put('cart', $cart);
        $cartCount = $this->getCartCount($cart);

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'cart_subtotal' => $this->getCartSubtotal($cart)
        ]);
    }

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
        $cartCount = $this->getCartCount($cart);

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'cart_subtotal' => $this->getCartSubtotal($cart),
            'item_removed' => ($newQuantity < 1)
        ]);
    }

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
        $cartCount = $this->getCartCount($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $cartCount,
            'cart_subtotal' => $this->getCartSubtotal($cart)
        ]);
    }

    public function getCartData()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->getCartSubtotal($cart);
        $shipping = $subtotal > 500000 ? 0 : 1000;
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
                'product' => $product ? [
                    'slug' => $product->slug,
                    'stock' => $product->stock,
                ] : null
            ];
        }

        return response()->json([
            'success' => true,
            'cart_items' => $formattedCart,
            'cart_count' => $this->getCartCount($cart),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $cart = $this->validateCartItems($cart);
        session()->put('cart', $cart);

        $cartCount = $this->getCartCount($cart);
        $subtotal = $this->getCartSubtotal($cart);
        $shipping = $subtotal > 500000 ? 0 : 1000;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $tax + $shipping;



        return view('home.view_cart', compact('cart', 'cartCount', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function clearCart()
    {
        session()->forget('cart');
        $cartCount = $this->getCartCount([]);

        return response()->json([
            'success' => true,
            'message' => 'Cart has been cleared',
            'cart_count' => $cartCount,
            'cart_subtotal' => 0
        ]);
    }

    // Helper methods
    private function generateCartKey($productId, $size)
    {
        return md5($productId . $size);
    }

    private function getCartCount($cart)
    {
        return array_reduce($cart, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    private function getCartSubtotal($cart)
    {
        return array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    private function validateCartItems($cart)
    {
        return collect($cart)->filter(function ($item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock < 1) return false;
            if ($item['quantity'] > $product->stock) {
                $item['quantity'] = $product->stock;
            }
            return true;
        })->toArray();
    }
}
