<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // Get the category by slug
        $category = Category::where('slug', $slug)
            ->withCount('products') // Optional: get product count
            ->firstOrFail();

        // Get paginated products for this category
        $products = Product::where('category_id', $category->id)
            ->where('status', 'active') // Only show active products
            ->orderBy('is_featured', 'desc') // Featured products first
            ->orderBy('created_at', 'desc') // Then newest products
            ->paginate(12); // 12 products per page

        // Return the view with category and products data
        return view('categories.show', compact('category', 'products'));
    }
}
