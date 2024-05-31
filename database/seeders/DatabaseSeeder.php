<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
        ]);

        
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description for Product 1',
                'price' => 100,
                'image' => 'images/product.jpeg', 
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for Product 2',
                'price' => 200,
                'image' => 'images/product.jpeg', 
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description for Product 3',
                'price' => 300,
                'image' => 'images/product.jpeg', 
            ],
            [
                'name' => 'Product 4',
                'description' => 'Description for Product 4',
                'price' => 400,
                'image' => 'images/product.jpeg', 
            ],
            [
                'name' => 'Product 5',
                'description' => 'Description for Product 5',
                'price' => 500,
                'image' => 'images/product.jpeg', 
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
