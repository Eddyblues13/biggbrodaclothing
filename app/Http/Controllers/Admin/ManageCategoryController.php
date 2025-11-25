<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Start with a query builder
        $query = Category::withCount('products')->latest();

        // Apply filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('meta_title', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active');
        }

        // IMPORTANT: Use paginate() to get a LengthAwarePaginator instance
        $categories = $query->paginate(10);

        return view('admin.manage_category', compact('categories'));
    }

    public function create()
    {
        return view('admin.create_category');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        try {
            Category::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'],
                'is_active' => $request->has('is_active'),
                'position' => $validated['position'] ?? 0,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    public function show(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->latest()->take(5);
        }]);
        
        return view('admin.category_details', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.edit_category', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        try {
            $category->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'],
                'is_active' => $request->has('is_active'),
                'position' => $validated['position'] ?? $category->position,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->products()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete category with associated products. Please reassign or delete the products first.');
            }

            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Category $category)
    {
        try {
            $category->update([
                'is_active' => !$category->is_active
            ]);

            $status = $category->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "Category {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating category status: ' . $e->getMessage());
        }
    }
}