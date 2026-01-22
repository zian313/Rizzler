<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get Fashion category
        $fashionCategory = Category::where('name', 'Fashion')->first();

        if (!$fashionCategory) {
            $fashionCategory = Category::create([
                'name' => 'Fashion',
                'description' => 'Koleksi pakaian dan aksesori fashion'
            ]);
        }

        // Add Products
        $products = [
            [
                'name' => 'Celana Jogger Beige',
                'description' => 'Celana jogger nyaman dengan material premium berkualitas tinggi. Cocok untuk aktivitas sehari-hari maupun olahraga ringan. Desain minimalis dengan detail jahitan rapi dan elastic waistband yang ergonomis.',
                'price' => 299000,
                'stock' => 25,
                'category_id' => $fashionCategory->id,
            ],
            [
                'name' => 'Hoodie Putih Grafis',
                'description' => 'Hoodie oversized dengan desain grafis unik yang trendy. Terbuat dari cotton blend yang soft dan breathable. Dilengkapi dengan front pocket dan drawstring yang dapat diatur. Cocok untuk casual wear dan hangout dengan teman.',
                'price' => 449000,
                'stock' => 18,
                'category_id' => $fashionCategory->id,
            ],
            [
                'name' => 'Sabuk Dua Warna',
                'description' => 'Sabuk elegan dengan kombinasi warna hitam dan putih yang stylish. Material kulit berkualitas dengan buckle metal yang kokoh. Dapat menjadi aksesori pelengkap untuk berbagai jenis outfit. Ukuran dapat disesuaikan dengan mudah.',
                'price' => 189000,
                'stock' => 35,
                'category_id' => $fashionCategory->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
