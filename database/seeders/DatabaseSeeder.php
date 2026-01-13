<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed Categories
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Produk elektronik dan gadget terbaru'
            ],
            [
                'name' => 'Fashion',
                'description' => 'Koleksi pakaian dan aksesori fashion'
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Makanan dan minuman berkualitas'
            ],
            [
                'name' => 'Buku',
                'description' => 'Koleksi buku dan literatur'
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'description' => 'Peralatan dan perlengkapan rumah tangga'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
