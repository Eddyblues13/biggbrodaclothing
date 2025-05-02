<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use Cloudinary\Cloudinary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ]);

        // ======================
        // 1. Seed Categories
        // ======================
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Latest gadgets and devices',
                'slug' => 'electronics',
                'meta_title' => 'Electronics Store | Bigg Broda',
                'meta_description' => 'Shop smartphones, laptops, and accessories',
                'meta_keywords' => 'electronics, gadgets, tech',
                'is_active' => true,
                'position' => 1
            ],
            [
                'name' => 'Men\'s Clothing',
                'description' => 'Trendy apparel for men',
                'slug' => 'mens-clothing',
                'meta_title' => 'Men\'s Fashion | Bigg Broda',
                'meta_description' => 'Premium shirts, jeans, and streetwear',
                'meta_keywords' => 'clothing, menswear, fashion',
                'is_active' => true,
                'position' => 2
            ],
            [
                'name' => 'Home & Living',
                'description' => 'Furniture and decor',
                'slug' => 'home-living',
                'meta_title' => 'Home Essentials | Bigg Broda',
                'meta_description' => 'Stylish furniture and home accessories',
                'meta_keywords' => 'home, furniture, decor',
                'is_active' => true,
                'position' => 3
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // ======================
        // 2. Seed Products
        // ======================
        $products = [
            // Electronics (Category ID: 1)
            [
                'category_id' => 1,
                'name' => 'Smartphone Pro X',
                'slug' => 'smartphone-pro-x',
                'description' => '6.7" AMOLED, 128GB storage, 48MP camera',
                'short_description' => 'Flagship smartphone with pro camera',
                'sku' => 'ELEC-SPX-2024',
                'brand' => 'TechMaster',
                'price' => 899.99,
                'discount_price' => 849.99,
                'size' => null,
                'color' => 'Midnight Black',
                'stock' => 150,
                'min_stock' => 20,
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => 'Smartphone Pro X | Bigg Broda Electronics',
                'meta_description' => 'Buy the latest Smartphone Pro X with 48MP camera',
                'meta_keywords' => 'smartphone, tech, mobile'
            ],
            [
                'category_id' => 1,
                'name' => 'Wireless Earbuds Pro',
                'slug' => 'wireless-earbuds-pro',
                'description' => 'Noise-cancelling, 24hr battery life',
                'short_description' => 'Premium sound quality',
                'sku' => 'ELEC-WEB-2024',
                'brand' => 'AudioPlus',
                'price' => 199.99,
                'discount_price' => 179.99,
                'size' => null,
                'color' => 'White',
                'stock' => 200,
                'min_stock' => 30,
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Wireless Earbuds Pro | Bigg Broda',
                'meta_description' => 'Noise-cancelling wireless earbuds',
                'meta_keywords' => 'earbuds, audio, wireless'
            ],
            [
                'category_id' => 1,
                'name' => 'Ultra HD Smart TV',
                'slug' => 'ultra-hd-smart-tv',
                'description' => '55" 4K HDR with streaming apps',
                'short_description' => 'Immersive viewing experience',
                'sku' => 'ELEC-TV-2024',
                'brand' => 'VisionPlus',
                'price' => 699.99,
                'discount_price' => 649.99,
                'size' => '55-inch',
                'color' => 'Black',
                'stock' => 75,
                'min_stock' => 10,
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => '4K Smart TV | Bigg Broda',
                'meta_description' => '55" Ultra HD Smart TV with HDR',
                'meta_keywords' => 'tv, television, 4k'
            ],

            // Men's Clothing (Category ID: 2)
            [
                'category_id' => 2,
                'name' => 'Slim Fit Denim Jeans',
                'slug' => 'slim-fit-denim-jeans',
                'description' => 'Stretch denim, 5-pocket design',
                'short_description' => 'Comfortable and stylish',
                'sku' => 'CLOTH-JEANS-001',
                'brand' => 'UrbanWear',
                'price' => 59.99,
                'discount_price' => 49.99,
                'size' => 'S,M,L,XL',
                'color' => 'Blue',
                'stock' => 120,
                'min_stock' => 25,
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Men\'s Slim Fit Jeans | Bigg Broda',
                'meta_description' => 'Premium denim jeans for men',
                'meta_keywords' => 'jeans, denim, menswear'
            ],
            [
                'category_id' => 2,
                'name' => 'Classic Cotton T-Shirt',
                'slug' => 'classic-cotton-tshirt',
                'description' => '100% cotton, crew neck',
                'short_description' => 'Essential wardrobe staple',
                'sku' => 'CLOTH-TS-001',
                'brand' => 'BasicWear',
                'price' => 24.99,
                'discount_price' => null,
                'size' => 'S,M,L,XL',
                'color' => 'White,Black,Gray',
                'stock' => 300,
                'min_stock' => 50,
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Men\'s Cotton T-Shirt | Bigg Broda',
                'meta_description' => 'Soft classic cotton t-shirt',
                'meta_keywords' => 'tshirt, cotton, basic'
            ],
            [
                'category_id' => 2,
                'name' => 'Bomber Jacket',
                'slug' => 'bomber-jacket',
                'description' => 'Nylon exterior, quilted lining',
                'short_description' => 'Trendy streetwear essential',
                'sku' => 'CLOTH-JACKET-001',
                'brand' => 'StreetStyle',
                'price' => 89.99,
                'discount_price' => 79.99,
                'size' => 'S,M,L,XL',
                'color' => 'Black',
                'stock' => 80,
                'min_stock' => 15,
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => 'Men\'s Bomber Jacket | Bigg Broda',
                'meta_description' => 'Stylish nylon bomber jacket',
                'meta_keywords' => 'jacket, bomber, outerwear'
            ],

            // Home & Living (Category ID: 3)
            [
                'category_id' => 3,
                'name' => 'Ceramic Coffee Mug Set',
                'slug' => 'ceramic-coffee-mug-set',
                'description' => 'Set of 4, dishwasher-safe',
                'short_description' => 'Elegant matte finish',
                'sku' => 'HOME-MUG-001',
                'brand' => 'HomeEssentials',
                'price' => 29.99,
                'discount_price' => 24.99,
                'size' => null,
                'color' => 'White',
                'stock' => 200,
                'min_stock' => 40,
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Coffee Mug Set | Bigg Broda',
                'meta_description' => 'Set of 4 ceramic coffee mugs',
                'meta_keywords' => 'mugs, kitchen, home'
            ],
            [
                'category_id' => 3,
                'name' => 'Modern Floor Lamp',
                'slug' => 'modern-floor-lamp',
                'description' => 'Adjustable height, LED compatible',
                'short_description' => 'Sleek contemporary design',
                'sku' => 'HOME-LAMP-001',
                'brand' => 'Lumiere',
                'price' => 129.99,
                'discount_price' => 109.99,
                'size' => '60-inch',
                'color' => 'Brushed Nickel',
                'stock' => 45,
                'min_stock' => 10,
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => 'Modern Floor Lamp | Bigg Broda',
                'meta_description' => 'Adjustable LED floor lamp',
                'meta_keywords' => 'lamp, lighting, home'
            ],
            [
                'category_id' => 3,
                'name' => 'Decorative Throw Pillow',
                'slug' => 'decorative-throw-pillow',
                'description' => '18x18", removable cover',
                'short_description' => 'Bohemian pattern',
                'sku' => 'HOME-PILLOW-001',
                'brand' => 'CozyHome',
                'price' => 39.99,
                'discount_price' => 34.99,
                'size' => '18x18 inches',
                'color' => 'Terracotta',
                'stock' => 150,
                'min_stock' => 30,
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Throw Pillow | Bigg Broda Home',
                'meta_description' => 'Bohemian decorative pillow',
                'meta_keywords' => 'pillow, decor, home'
            ]
        ];

        // ======================
        // 3. Process Products
        // ======================
        foreach ($products as $index => $productData) {
            $productNumber = $index + 1;
            $imagePath = public_path("assets/img/product-img/product-{$productNumber}.jpg");

            // Skip if image doesn't exist (or use a default)
            if (!File::exists($imagePath)) {
                $this->command->warn("Image not found: {$imagePath}");
                continue;
            }

            // Upload main product image to Cloudinary
            $uploadResult = $cloudinary->uploadApi()->upload($imagePath, [
                'folder' => 'biggbrodaclothing/products',
                'transformation' => ['width' => 800, 'height' => 800, 'crop' => 'fill']
            ]);

            // Create product with Cloudinary URLs
            $product = Product::create(array_merge($productData, [
                'image' => $uploadResult['secure_url'],
                'image_public_id' => $uploadResult['public_id'],
                'gallery' => null
            ]));

            // Upload 3 gallery images per product
            for ($i = 1; $i <= 3; $i++) {
                $galleryImagePath = public_path("assets/img/product-img/product-{$productNumber}-{$i}.jpg");

                if (File::exists($galleryImagePath)) {
                    $galleryUpload = $cloudinary->uploadApi()->upload($galleryImagePath, [
                        'folder' => 'biggbrodaclothing/products/gallery',
                        'public_id' => "product-{$productNumber}-gallery-{$i}",
                        'transformation' => ['width' => 800, 'height' => 800, 'crop' => 'fill']
                    ]);

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'public_id' => $galleryUpload['public_id'],
                        'image_url' => $galleryUpload['secure_url'], // Add this
                        'position' => $i,
                        'is_default' => $i === 1
                    ]);
                }
            }
        }

        $this->command->info('Successfully seeded 3 categories and 9 products with galleries!');
    }
}
