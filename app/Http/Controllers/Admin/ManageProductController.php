<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ManageProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.manage_products', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.create_products', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'sku' => 'required|string|unique:products',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        try {
            // Upload main image
            $uploadedImage = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'products'
            ]);

            $galleryPublicIds = [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $galleryImage) {
                    $uploadedGallery = Cloudinary::upload($galleryImage->getRealPath(), [
                        'folder' => 'products/gallery'
                    ]);
                    $galleryPublicIds[] = $uploadedGallery->getPublicId();
                }
            }

            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'short_description' => $validated['short_description'],
                'sku' => $validated['sku'],
                'brand' => $validated['brand'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'],
                'size' => $validated['size'],
                'color' => $validated['color'],
                'stock' => $validated['stock'],
                'min_stock' => $validated['min_stock'],
                'image_public_id' => $uploadedImage->getPublicId(),
                'gallery' => $galleryPublicIds,
                'category_id' => $validated['category_id'],
                'is_featured' => $request->has('is_featured'),
                'is_bestseller' => $request->has('is_bestseller'),
                'is_new' => $request->has('is_new'),
                'status' => $validated['status'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'],
            ]);

            return redirect()->route('admin.products')->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.edit_product', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'short_description' => $validated['short_description'],
                'sku' => $validated['sku'],
                'brand' => $validated['brand'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'],
                'size' => $validated['size'],
                'color' => $validated['color'],
                'stock' => $validated['stock'],
                'min_stock' => $validated['min_stock'],
                'category_id' => $validated['category_id'],
                'is_featured' => $request->has('is_featured'),
                'is_bestseller' => $request->has('is_bestseller'),
                'is_new' => $request->has('is_new'),
                'status' => $validated['status'],
                'meta_title' => $validated['meta_title'],
                'meta_description' => $validated['meta_description'],
                'meta_keywords' => $validated['meta_keywords'],
            ];

            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image_public_id) {
                    Cloudinary::destroy($product->image_public_id);
                }

                $uploadedImage = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'products'
                ]);
                $updateData['image_public_id'] = $uploadedImage->getPublicId();
            }

            if ($request->hasFile('gallery')) {
                // Delete old gallery images
                if (!empty($product->gallery)) {
                    foreach ($product->gallery as $oldPublicId) {
                        Cloudinary::destroy($oldPublicId);
                    }
                }

                $galleryPublicIds = [];
                foreach ($request->file('gallery') as $galleryImage) {
                    $uploadedGallery = Cloudinary::upload($galleryImage->getRealPath(), [
                        'folder' => 'products/gallery'
                    ]);
                    $galleryPublicIds[] = $uploadedGallery->getPublicId();
                }
                $updateData['gallery'] = $galleryPublicIds;
            }

            $product->update($updateData);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Delete images from Cloudinary
            if ($product->image_public_id) {
                Cloudinary::destroy($product->image_public_id);
            }

            if (!empty($product->gallery)) {
                foreach ($product->gallery as $publicId) {
                    Cloudinary::destroy($publicId);
                }
            }

            $product->delete();

            return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()->with('success', 'Product status updated successfully.');
    }
}