<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    // public function show($slug)
    // {
    //     // Get the category by slug
    //     $category = Category::where('slug', $slug)
    //         ->withCount('products') // Optional: get product count
    //         ->firstOrFail();

    //     // Get paginated products for this category
    //     $products = Product::where('category_id', $category->id)
    //         ->where('status', 'active') // Only show active products
    //         ->orderBy('is_featured', 'desc') // Featured products first
    //         ->orderBy('created_at', 'desc') // Then newest products
    //         ->paginate(12); // 12 products per page

    //     // Return the view with category and products data
    //     return view('categories.show', compact('category', 'products'));
    // }


    /**
     * Display a listing of all categories
     */
    public function index()
    {
        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('position')
            ->get();

        return view('home.categories.index', compact('categories'));
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        $products = $category->products()
            ->active()
            ->with('category')
            ->paginate(12);

        return view('home.categories.show', compact('category', 'products'));
    }
}
