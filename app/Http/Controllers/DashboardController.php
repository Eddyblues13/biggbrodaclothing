<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // DashboardController.php
    public function index()
    {
        $user = Auth::user();
        $totalOrders = $user->orders()->count();
        $recentOrders = $user->orders()->latest()->take(2)->get();
        $addresses = $user->addresses()->get();


        return view('auth.dashboard', [
            'user' => $user,
            'totalOrders' => $totalOrders,

            'recentOrders' => $recentOrders,
            'addresses' => $addresses,

        ]);
    }
}
