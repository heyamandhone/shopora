<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@shopora.com',
        ]);

        Category::factory(20)->create();

        Brand::factory(30)->create();

        Product::factory(500)->create();
    }
}
