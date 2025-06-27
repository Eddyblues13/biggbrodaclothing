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
        // 1. Seed Clothing Categories
        // ======================
        $categories = [
            [
                'name' => 'Men\'s Clothing',
                'description' => 'Trendy apparel for men',
                'slug' => 'mens-clothing',
                'meta_title' => 'Men\'s Fashion | Bigg Broda',
                'meta_description' => 'Premium shirts, jeans, and streetwear',
                'meta_keywords' => 'clothing, menswear, fashion',
                'is_active' => true,
                'position' => 1
            ],
            [
                'name' => 'Women\'s Clothing',
                'description' => 'Chic styles for women',
                'slug' => 'womens-clothing',
                'meta_title' => 'Women\'s Fashion | Bigg Broda',
                'meta_description' => 'Dresses, tops, and women\'s accessories',
                'meta_keywords' => 'womenswear, dresses, fashion',
                'is_active' => true,
                'position' => 2
            ],
            [
                'name' => 'Kids\' Collection',
                'description' => 'Adorable outfits for children',
                'slug' => 'kids-collection',
                'meta_title' => 'Kids Fashion | Bigg Broda',
                'meta_description' => 'Cute and comfortable clothing for kids',
                'meta_keywords' => 'kids, children, clothing',
                'is_active' => true,
                'position' => 3
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // ======================
        // 2. Seed Clothing Products
        // ======================
        $products = [
            // Men's Clothing (Category ID: 1)
            [
                'category_id' => 1,
                'name' => 'Slim Fit Denim Jeans',
                'slug' => 'slim-fit-denim-jeans',
                'description' => 'Stretch denim, 5-pocket design',
                'short_description' => 'Comfortable and stylish',
                'sku' => 'MEN-JEANS-001',
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
                'category_id' => 1,
                'name' => 'Classic Cotton T-Shirt',
                'slug' => 'classic-cotton-tshirt',
                'description' => '100% cotton, crew neck',
                'short_description' => 'Essential wardrobe staple',
                'sku' => 'MEN-TS-001',
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
                'category_id' => 1,
                'name' => 'Bomber Jacket',
                'slug' => 'bomber-jacket',
                'description' => 'Nylon exterior, quilted lining',
                'short_description' => 'Trendy streetwear essential',
                'sku' => 'MEN-JACKET-001',
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

            // Women's Clothing (Category ID: 2)
            [
                'category_id' => 2,
                'name' => 'Floral Summer Dress',
                'slug' => 'floral-summer-dress',
                'description' => 'Lightweight chiffon, knee-length',
                'short_description' => 'Perfect for warm days',
                'sku' => 'WOM-DRESS-001',
                'brand' => 'FeminineStyle',
                'price' => 65.99,
                'discount_price' => 55.99,
                'size' => 'XS,S,M,L',
                'color' => 'Floral Print',
                'stock' => 90,
                'min_stock' => 20,
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => 'Women\'s Summer Dress | Bigg Broda',
                'meta_description' => 'Lightweight floral chiffon dress',
                'meta_keywords' => 'dress, summer, floral'
            ],
            [
                'category_id' => 2,
                'name' => 'High-Waisted Leggings',
                'slug' => 'high-waisted-leggings',
                'description' => 'Buttery soft fabric, squat-proof',
                'short_description' => 'Comfort meets style',
                'sku' => 'WOM-LEG-001',
                'brand' => 'YogaComfort',
                'price' => 39.99,
                'discount_price' => 34.99,
                'size' => 'S,M,L,XL',
                'color' => 'Black,Navy',
                'stock' => 200,
                'min_stock' => 40,
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Women\'s Leggings | Bigg Broda',
                'meta_description' => 'High-waisted performance leggings',
                'meta_keywords' => 'leggings, activewear, yoga'
            ],
            [
                'category_id' => 2,
                'name' => 'Knit Cardigan',
                'slug' => 'knit-cardigan',
                'description' => 'Oversized fit, soft wool blend',
                'short_description' => 'Cozy layering piece',
                'sku' => 'WOM-CARD-001',
                'brand' => 'CozyKnits',
                'price' => 75.00,
                'discount_price' => 65.00,
                'size' => 'S,M,L',
                'color' => 'Cream',
                'stock' => 70,
                'min_stock' => 15,
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => 'Women\'s Cardigan | Bigg Broda',
                'meta_description' => 'Oversized knit cardigan',
                'meta_keywords' => 'cardigan, knit, sweater'
            ],

            // Kids' Collection (Category ID: 3)
            [
                'category_id' => 3,
                'name' => 'Kids Graphic Tee',
                'slug' => 'kids-graphic-tee',
                'description' => '100% cotton, fun prints',
                'short_description' => 'Comfortable playwear',
                'sku' => 'KID-TEE-001',
                'brand' => 'PlayfulKids',
                'price' => 19.99,
                'discount_price' => 16.99,
                'size' => '4-5,6-7,8-9',
                'color' => 'Blue,Red,Green',
                'stock' => 150,
                'min_stock' => 30,
                'is_featured' => false,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Kids T-Shirts | Bigg Broda',
                'meta_description' => 'Fun graphic tees for children',
                'meta_keywords' => 'kids, tshirt, children'
            ],
            [
                'category_id' => 3,
                'name' => 'Denim Overalls',
                'slug' => 'denim-overalls',
                'description' => 'Adjustable straps, durable denim',
                'short_description' => 'Play-ready clothing',
                'sku' => 'KID-OVER-001',
                'brand' => 'LittleOnes',
                'price' => 45.99,
                'discount_price' => 39.99,
                'size' => '2T,3T,4T',
                'color' => 'Denim Blue',
                'stock' => 85,
                'min_stock' => 20,
                'is_featured' => true,
                'is_bestseller' => false,
                'is_new' => true,
                'status' => 'active',
                'meta_title' => 'Kids Overalls | Bigg Broda',
                'meta_description' => 'Durable denim overalls for toddlers',
                'meta_keywords' => 'overalls, kids, denim'
            ],
            [
                'category_id' => 3,
                'name' => 'Hooded Jacket',
                'slug' => 'hooded-jacket',
                'description' => 'Water-resistant, warm fleece lining',
                'short_description' => 'For chilly days',
                'sku' => 'KID-JACKET-001',
                'brand' => 'OutdoorKids',
                'price' => 55.00,
                'discount_price' => 49.99,
                'size' => '5-6,7-8,9-10',
                'color' => 'Red,Blue',
                'stock' => 65,
                'min_stock' => 15,
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new' => false,
                'status' => 'active',
                'meta_title' => 'Kids Jacket | Bigg Broda',
                'meta_description' => 'Warm hooded jacket for children',
                'meta_keywords' => 'jacket, kids, outerwear'
            ]
        ];

        // ======================
        // 3. Process Products
        // ======================
        foreach ($products as $index => $productData) {
            $productNumber = $index + 1;
            $imagePath = public_path("assets/img/products/f{$productNumber}.jpg");

            // Skip if image doesn't exist
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
                $galleryImagePath = public_path("assets/img/products/product-{$productNumber}-{$i}.jpg");

                if (File::exists($galleryImagePath)) {
                    $galleryUpload = $cloudinary->uploadApi()->upload($galleryImagePath, [
                        'folder' => 'biggbrodaclothing/products/gallery',
                        'public_id' => "product-{$productNumber}-gallery-{$i}",
                        'transformation' => ['width' => 800, 'height' => 800, 'crop' => 'fill']
                    ]);

                    ProductGallery::create([
                        'product_id' => $product->id,
                        'public_id' => $galleryUpload['public_id'],
                        'image_url' => $galleryUpload['secure_url'],
                        'position' => $i,
                        'is_default' => $i === 1
                    ]);
                }
            }
        }

        $this->command->info('Successfully seeded 3 clothing categories and 9 products with galleries!');
    }
}
