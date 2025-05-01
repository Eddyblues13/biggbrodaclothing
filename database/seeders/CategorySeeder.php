<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => "Men's Apparel",
                'description' => "Stylish clothing for men",
                'is_active' => true,
                'position' => 1,
            ],
            [
                'name' => "Women's Fashion",
                'description' => "Trendy outfits for women",
                'is_active' => true,
                'position' => 2,
            ],
            [
                'name' => "Footwear",
                'description' => "Shoes for all occasions",
                'is_active' => true,
                'position' => 3,
            ],
            [
                'name' => "Accessories",
                'description' => "Complete your look with our accessories",
                'is_active' => true,
                'position' => 4,
            ],
            [
                'name' => "Activewear",
                'description' => "Performance clothing for your active lifestyle",
                'is_active' => true,
                'position' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'slug' => Str::slug($category['name']),
                'is_active' => $category['is_active'],
                'position' => $category['position'],
                'meta_title' => "Buy {$category['name']} Online",
                'meta_description' => $category['description'],
                'meta_keywords' => strtolower($category['name']) . ', fashion, clothing, buy online',
            ]);
        }
    }
}
