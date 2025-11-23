<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalOrders = $user->orders()->count();
        $pendingOrders = $user->orders()->whereIn('status', ['pending', 'processing'])->count();
        $completedOrders = $user->orders()->where('status', 'delivered')->count();
        
        $recentOrders = $user->orders()
            ->with(['orderItems.product'])
            ->latest()
            ->take(5)
            ->get();
            
        $addresses = $user->addresses()->get();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();

        // You'll need to implement wishlist count based on your Favorite model
        $wishlistCount = 0; // Replace with actual wishlist count logic

        return view('auth.dashboard', [
            'user' => $user,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'recentOrders' => $recentOrders,
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress,
            'wishlistCount' => $wishlistCount,
        ]);
    }
}