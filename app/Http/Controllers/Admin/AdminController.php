<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // User Statistics
        $newUsersCount = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $totalUsersCount = User::count();

    

         // Recent Activity
         $recentUsers = User::latest()->take(5)->get();

        return view('admin.home', compact(
            'newUsersCount',
            'totalUsersCount',
            
            'recentUsers',
        ));
    }
}
