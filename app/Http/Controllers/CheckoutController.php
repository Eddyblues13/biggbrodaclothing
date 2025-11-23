<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout');
        }

        // Check if cart is not empty
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Get current step from query string or default to 1
        $currentStep = $request->query('step', 1);
        $currentStep = in_array($currentStep, [1, 2, 3]) ? (int)$currentStep : 1;

        // Get checkout data from session
        $checkoutData = Session::get('checkout_data', []);

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
        // Check if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login to continue'], 401);
        }

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
    // Check if user is logged in
    if (!Auth::check()) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to complete your order'
            ], 401);
        }
        return redirect()->route('login')->with('error', 'Please login to complete your order');
    }

    // Get checkout data from session
    $checkoutData = Session::get('checkout_data', []);
    $cart = Session::get('cart', []);

    // Check if cart is empty
    if (empty($cart)) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }
        return redirect()->route('cart.index')->with('error', 'Your cart is empty');
    }

    // Final validation
    $request->validate([
        'terms' => 'accepted'
    ], [
        'terms.accepted' => 'You must accept the terms and conditions'
    ]);

    // Calculate final amounts
    $subtotal = $this->getCartSubtotal($cart);
    $shipping = isset($checkoutData['shipping_method']) && $checkoutData['shipping_method'] === 'express' ? 15000 : ($subtotal > 500000 ? 0 : 1000);
    $tax = $subtotal * 0.05;
    $total = $subtotal + $shipping + $tax;

    try {
        DB::beginTransaction();

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'first_name' => $checkoutData['first_name'],
            'last_name' => $checkoutData['last_name'],
            'email' => $checkoutData['email'],
            'phone' => $checkoutData['phone'],
            'address1' => $checkoutData['address1'],
            'address2' => $checkoutData['address2'] ?? null,
            'city' => $checkoutData['city'],
            'state' => $checkoutData['state'],
            'postcode' => $checkoutData['postcode'] ?? null,
            'country' => 'Nigeria',
            'shipping_method' => $checkoutData['shipping_method'],
            'payment_method' => $checkoutData['payment_method'],
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'tax_amount' => $tax,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'order_date' => now(),
        ]);

        // Create order items with all required fields
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'product_slug' => $item['slug'] ?? $product->slug ?? 'unknown',
                'product_image' => $item['image'] ?? $product->image_url ?? '',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'size' => $item['size'] ?? null,
                'color' => $item['color'] ?? null,
            ]);
        }

        DB::commit();

        // Prepare Flutterwave payment data
        $paymentData = [
            'tx_ref' => $order->order_number,
            'amount' => $total,
            'currency' => 'NGN',
            'payment_options' => 'card, banktransfer, ussd',
            'redirect_url' => route('payment.callback'),
            'customer' => [
                'email' => $order->email,
                'phonenumber' => $order->phone,
                'name' => $order->first_name . ' ' . $order->last_name,
            ],
            'customizations' => [
                'title' => 'Biggbroda Clothing',
                'description' => 'Order Payment - ' . $order->order_number,
                'logo' => asset('img/logo.png'),
            ],
            'meta' => [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
            ],
        ];

        // Create Flutterwave payment link
        $paymentURL = $this->createFlutterwavePaymentLink($paymentData);
        
        if ($paymentURL) {
            // Store order ID in session for callback
            Session::put('current_order_id', $order->id);
            
            // If it's an AJAX request, return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'payment_url' => $paymentURL,
                    'order_id' => $order->id,
                ]);
            }
            
            // Otherwise, redirect directly to Flutterwave
            return redirect()->away($paymentURL);
            
        } else {
            throw new \Exception('Failed to create payment link');
        }

    } catch (\Exception $e) {
        DB::rollBack();
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process order: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()->with('error', 'Failed to process order: ' . $e->getMessage());
    }
}

    /**
     * Create Flutterwave payment link
     */
    private function createFlutterwavePaymentLink($data)
    {
        $client = new Client();
        $url = 'https://api.flutterwave.com/v3/payments';

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            $body = json_decode($response->getBody(), true);

            if ($body['status'] === 'success') {
                return $body['data']['link'];
            }
        } catch (\Exception $e) {
            report($e);
        }

        return null;
    }

    /**
     * Handle Flutterwave callback
     */
    public function handleCallback(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $orderId = Session::get('current_order_id');

        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Invalid order session');
        }

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found');
        }

        // Verify payment with Flutterwave
        $verification = $this->verifyFlutterwavePayment($transactionId);

        if ($verification && $verification['status'] === 'success') {
            // Update order status
            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid',
                'transaction_id' => $transactionId,
                'paid_at' => now(),
            ]);

            // Update product stock
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            Session::forget('current_order_id');
            Session::forget('cart');
            Session::forget('checkout_data');

            return redirect()->route('order.receipt', $order->order_number)
                ->with('success', 'Payment completed successfully!');
        } else {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'Payment failed. Please try again.');
        }
    }

    /**
     * Verify Flutterwave payment
     */
    private function verifyFlutterwavePayment($transactionId)
    {
        $client = new Client();
        $url = "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify";

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            report($e);
        }

        return null;
    }

    public function orderReceipt($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('orderItems')
            ->firstOrFail();

        return view('home.order_receipt', compact('order'));
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