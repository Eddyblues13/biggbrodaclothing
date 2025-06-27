<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Get current step from query string or default to 1
        $currentStep = $request->query('step', 1);
        $currentStep = in_array($currentStep, [1, 2, 3]) ? (int)$currentStep : 1;

        // Get checkout data from session
        $checkoutData = Session::get('checkout_data', []);

        $cart = Session::get('cart', []);

        // Validate and adjust cart items
        $validatedCart = $this->validateCartItems($cart);
        $cartAdjusted = count($cart) !== count($validatedCart);

        if ($cartAdjusted) {
            Session::put('cart', $validatedCart);
            $cart = $validatedCart;
        }

        $cartCount = $this->getCartCount($cart);
        $subtotal = $this->getCartSubtotal($cart);

        // Calculate shipping - free over ₦500,000
        $shipping = $subtotal > 500000 ? 0 : 1000;

        // Override shipping if express was selected in session
        if (isset($checkoutData['shipping_method'])) {
            $shipping = $checkoutData['shipping_method'] === 'express' ? 15000 : $shipping;
        }

        $tax = $subtotal * 0.05; // 5% tax
        $total = $subtotal + $shipping + $tax;

        return view('home.checkout', compact(
            'cart',
            'cartCount',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'cartAdjusted',
            'currentStep',
            'checkoutData'
        ));
    }

    public function saveStep(Request $request, $step)
    {
        // Validate step data
        $rules = [];
        $messages = [];

        switch ($step) {
            case 1:
                $rules = [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'phone' => 'required|string|max:20',
                    'address1' => 'required|string|max:255',
                    'address2' => 'nullable|string|max:255',
                    'city' => 'required|string|max:100',
                    'state' => 'required|string|max:100',
                    'postcode' => 'nullable|string|max:20',
                    'shipping_method' => 'required|in:standard,express'
                ];

                $messages = [
                    'shipping_method.required' => 'Please select a shipping method',
                    'shipping_method.in' => 'Invalid shipping method selected',
                ];
                break;

            case 2:
                $rules = [
                    'payment_method' => 'required|in:card,bank_transfer,paypal'
                ];

                $messages = [
                    'payment_method.required' => 'Please select a payment method',
                    'payment_method.in' => 'Invalid payment method selected',
                ];

                if ($request->input('payment_method') === 'card') {
                    $rules['card_number'] = 'required|string|min:16|max:19';
                    $rules['expiry_date'] = 'required|regex:/^\d{2}\/\d{2}$/';
                    $rules['cvv'] = 'required|string|min:3|max:4';
                    $rules['card_name'] = 'required|string|max:255';

                    $messages['expiry_date.regex'] = 'Expiry date must be in MM/YY format';
                }
                break;
        }

        $validated = $request->validate($rules, $messages);

        // Save to session
        $checkoutData = Session::get('checkout_data', []);
        $mergedData = array_merge($checkoutData, $validated);
        Session::put('checkout_data', $mergedData);

        // Redirect to next step
        $nextStep = $step + 1;
        return redirect()->route('checkout.index', ['step' => $nextStep]);
    }

    public function process(Request $request)
    {
        // Get checkout data from session
        $checkoutData = Session::get('checkout_data', []);

        // Final validation
        $request->validate([
            'terms' => 'accepted'
        ], [
            'terms.accepted' => 'You must accept the terms and conditions'
        ]);

        // Merge all checkout data
        $orderData = array_merge($checkoutData, ['terms' => true]);

        // TODO: Add actual order processing logic:
        // 1. Create order record
        // 2. Create order items
        // 3. Process payment
        // 4. Update product stock
        // 5. Send confirmation email

        // Clear session data
        Session::forget('cart');
        Session::forget('checkout_data');

        // Redirect to confirmation page
        return redirect()->route('order.confirmation');
    }

    // Helper methods
    private function validateCartItems($cart)
    {
        $validated = [];
        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);

            // Skip if product doesn't exist or out of stock
            if (!$product || $product->stock < 1) {
                continue;
            }

            // Adjust quantity to available stock
            $quantity = min($item['quantity'], $product->stock);

            $validated[$key] = [
                'product_id' => $item['product_id'],
                'name' => $item['name'],
                'quantity' => $quantity,
                'price' => $item['price'],
                'image' => $item['image'],
                'slug' => $item['slug'],
                'size' => $item['size'],
                'stock' => $product->stock,
            ];
        }
        return $validated;
    }

    private function getCartCount($cart)
    {
        return array_reduce($cart, function ($total, $item) {
            return $total + $item['quantity'];
        }, 0);
    }

    private function getCartSubtotal($cart)
    {
        return array_reduce($cart, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }
}
