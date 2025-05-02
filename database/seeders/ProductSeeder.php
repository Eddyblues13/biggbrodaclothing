<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGallery;
use Cloudinary\Cloudinary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    protected $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    public function run()
    {
        $products = [
            [
                'category_name' => "Men's Apparel",
                'name' => 'Slim Fit Oxford Shirt',
                'description' => 'Premium cotton slim fit shirt with button-down collar',
                'brand' => 'FashionForward',
                'price' => 59.99,
                'discount_price' => 49.99,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Blue', 'White'],
                'stock' => 100,
                'image_url' => 'https://example.com/images/mens-shirt.jpg',
                'gallery_urls' => [
                    'https://example.com/images/mens-shirt-2.jpg',
                    'https://example.com/images/mens-shirt-3.jpg'
                ],
                'is_featured' => true,
                'is_bestseller' => true,
                'status' => 'active'
            ],
            [
                'category_name' => "Women's Fashion",
                'name' => 'Floral Wrap Dress',
                'description' => 'Elegant wrap dress with floral pattern',
                'brand' => 'ChicStyle',
                'price' => 79.99,
                'sizes' => ['XS', 'S', 'M'],
                'colors' => ['Multicolor', 'Navy'],
                'stock' => 75,
                'image_url' => 'https://example.com/images/womens-dress.jpg',
                'gallery_urls' => [
                    'https://example.com/images/womens-dress-2.jpg',
                    'https://example.com/images/womens-dress-3.jpg'
                ],
                'is_featured' => true,
                'status' => 'active'
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category_name'])->first();

            if (!$category) {
                $this->command->warn("Category '{$productData['category_name']}' not found. Skipping product '{$productData['name']}'.");
                continue;
            }

            $mainImage = $this->uploadToCloudinary($productData['image_url'], 'biggbrodaclothing');

            $galleryImages = [];
            foreach ($productData['gallery_urls'] ?? [] as $galleryUrl) {
                $uploaded = $this->uploadToCloudinary($galleryUrl, 'biggbrodaclothing/gallery');
                if ($uploaded) {
                    $galleryImages[] = $uploaded;
                }
            }

            $product = Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'short_description' => Str::limit($productData['description'], 100, '...'),
                'brand' => $productData['brand'],
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'] ?? null,
                'size' => implode(',', $productData['sizes'] ?? []),
                'color' => implode(',', $productData['colors'] ?? []),
                'stock' => $productData['stock'] ?? 0,
                'min_stock' => 10,
                'image' => $mainImage['secure_url'] ?? null,
                'image_public_id' => $mainImage['public_id'] ?? null,
                'gallery' => array_column($galleryImages, 'public_id'),
                'is_featured' => $productData['is_featured'] ?? false,
                'is_bestseller' => $productData['is_bestseller'] ?? false,
                'is_new' => true,
                'status' => $productData['status'] ?? 'active',
                'meta_title' => "Buy {$productData['name']} Online | {$productData['brand']}",
                'meta_description' => $productData['description'],
                'meta_keywords' => implode(', ', [
                    strtolower($productData['name']),
                    strtolower($productData['brand']),
                    strtolower(str_replace("'", '', $productData['category_name']))
                ]),
            ]);

            if (class_exists(ProductGallery::class)) {
                $this->createGalleryEntries($product, $galleryImages);
            }
        }
    }

    protected function uploadToCloudinary($imageUrl, $folder)
    {
        try {
            $uploadResult = $this->cloudinary->uploadApi()->upload($imageUrl, [
                'folder' => $folder,
                'transformation' => [
                    'width' => 800,
                    'height' => 1000,
                    'crop' => 'fill',
                    'quality' => 'auto',
                ]
            ]);

            return [
                'public_id' => $uploadResult['public_id'],
                'secure_url' => $uploadResult['secure_url'],
            ];
        } catch (\Exception $e) {
            $this->command->error("Failed to upload image: {$e->getMessage()}");
            return null;
        }
    }

    protected function createGalleryEntries($product, $galleryImages)
    {
        foreach ($galleryImages as $index => $image) {
            if (!$image) continue;

            ProductGallery::create([
                'product_id' => $product->id,
                'public_id' => $image['public_id'],
                'image_url' => $image['secure_url'],
                'position' => $index + 1,
                'is_default' => $index === 0,
            ]);
        }
    }
}
