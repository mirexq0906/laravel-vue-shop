<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'test',
            'email' => 'test@mail.ru',
            'password' => '12345'
        ]);
        Category::factory(10)->create();
        Author::factory(10)->create();
        Product::factory(150)->create();
        Order::factory(1)->create();

        $attachData = [];

        for ($i = 0; $i < 150; $i++) {
            $attachData[] = [
                'count' => 1,
                'product_id' => Product::all()->random()->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        Order::all()->random()->product()->attach($attachData);
    }
}
