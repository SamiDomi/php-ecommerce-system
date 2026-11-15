<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $home = Category::updateOrCreate(['slug' => 'home-goods'], ['name' => 'Home goods', 'description' => 'Everyday essentials for your home.']);
        $outdoors = Category::updateOrCreate(['slug' => 'outdoors'], ['name' => 'Outdoors', 'description' => 'Useful gear for getting outside.']);

        Product::updateOrCreate(['slug' => 'ceramic-mug'], [
            'category_id' => $home->id, 'name' => 'Ceramic Mug', 'description' => 'A sturdy everyday ceramic mug.',
            'price_cents' => 1800, 'stock' => 30, 'is_active' => true,
        ]);
        Product::updateOrCreate(['slug' => 'daypack'], [
            'category_id' => $outdoors->id, 'name' => 'Everyday Daypack', 'description' => 'A compact pack for daily adventures.',
            'price_cents' => 5499, 'stock' => 12, 'is_active' => true,
        ]);
    }
}
