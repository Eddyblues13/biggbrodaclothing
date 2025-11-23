<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // User Statistics
        $newUsersCount = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $totalUsersCount = User::count();
        $totalProductsCount = Product::count();
        $totalCategoriesCount = Category::count();
        $totalOrdersCount = Order::count();

        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Analytics data
        $userAnalytics = $this->getUserAnalytics();
        $orderAnalytics = $this->getOrderAnalytics();

        return view('admin.home', compact(
            'newUsersCount',
            'totalUsersCount',
            'totalProductsCount',
            'totalCategoriesCount',
            'totalOrdersCount',
            'recentUsers',
            'recentOrders',
            'userAnalytics',
            'orderAnalytics'
        ));
    }

    public function getAnalytics(Request $request)
    {
        $period = $request->get('period', 'month');
        
        return response()->json([
            'labels' => $this->getAnalyticsLabels($period),
            'data' => $this->getAnalyticsData($period)
        ]);
    }

    private function getUserAnalytics()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [65, 59, 80, 81, 56, 55]
        ];
    }

    private function getOrderAnalytics()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [28, 48, 40, 19, 86, 27]
        ];
    }

    private function getAnalyticsLabels($period)
    {
        switch ($period) {
            case 'week':
                return ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            case 'year':
                return ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            default: // month
                return ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        }
    }

    private function getAnalyticsData($period)
    {
        // This would typically come from your database
        switch ($period) {
            case 'week':
                return [12, 19, 3, 5, 2, 3, 15];
            case 'year':
                return [65, 59, 80, 81, 56, 55, 40, 45, 50, 30, 25, 35];
            default: // month
                return [12, 19, 3, 5];
        }
    }
}