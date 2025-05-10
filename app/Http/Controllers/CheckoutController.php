<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
      
        return view('home.checkout');
    }

    public function process(Request $request)
    {
        // Validate and process the order
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'terms' => 'accepted',
            'payment_method' => 'required|in:card,paypal,cod,bank_transfer'
        ]);

        // Process order and payment here
        // Redirect to order confirmation page on success
        
        return redirect()->route('order.confirmation');
    }
}
