<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Ayam Percik Pizza', 'description' => 'Tender grilled chicken with creamy Kelantan-style percik sauce.', 'price' => 28, 'category' => 'Classic'],
            ['name' => 'Ikan Bilis Crunch', 'description' => 'Crispy anchovies, onions, chili flakes, and mozzarella cheese.', 'price' => 20, 'category' => 'Classic'],
            ['name' => 'Sambal Udang Village', 'description' => 'Juicy prawns topped with spicy homemade sambal and melted cheese.', 'price' => 25, 'category' => 'Spicy'],
            ['name' => 'Pedas Giler Kampung', 'description' => "Bird's eye chilies, spicy sambal, chicken slices, and extra cheese.", 'price' => 40, 'category' => 'Spicy'],
            ['name' => "D'Kampong Signature", 'description' => 'Chicken rendang, sambal, mushrooms, onions, and premium cheese blend.', 'price' => 45, 'category' => 'Premium'],
            ['name' => 'Rendang Tok Special', 'description' => 'Traditional beef rendang with mozzarella and fresh herbs.', 'price' => 30, 'category' => 'Premium'],
            ['name' => 'Sotong Bakar Pizza', 'description' => 'Grilled squid, smoky sambal, mozzarella, and fresh herbs.', 'price' => 40, 'category' => 'Premium'],
            ['name' => 'Ulam Garden Pizza', 'description' => 'Fresh vegetables, herbs, cherry tomatoes, and garlic cream sauce.', 'price' => 20, 'category' => 'Vegetarian'],
            ['name' => 'Cendawan Hutan', 'description' => 'Mixed mushrooms, garlic butter, herbs, and creamy mozzarella.', 'price' => 25, 'category' => 'Vegetarian'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
