<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'min' => 1500, 'max' => 12000],
            ['name' => 'Mechanical Gaming Keyboard', 'min' => 2500, 'max' => 15000],
            ['name' => 'Wireless Gaming Mouse', 'min' => 800, 'max' => 7000],
            ['name' => 'Smart LED Television', 'min' => 18000, 'max' => 120000],
            ['name' => 'Portable Bluetooth Speaker', 'min' => 1200, 'max' => 18000],
            ['name' => 'Smart Fitness Watch', 'min' => 2000, 'max' => 25000],
            ['name' => 'Premium Running Shoes', 'min' => 2000, 'max' => 15000],
            ['name' => 'Classic Cotton T-Shirt', 'min' => 500, 'max' => 3000],
            ['name' => 'Leather Laptop Backpack', 'min' => 1200, 'max' => 8000],
            ['name' => 'Stainless Steel Water Bottle', 'min' => 400, 'max' => 2500],
            ['name' => 'Fast Charging Power Bank', 'min' => 1000, 'max' => 7000],
            ['name' => 'USB-C Fast Charger', 'min' => 600, 'max' => 4000],
            ['name' => 'Premium Sunglasses', 'min' => 800, 'max' => 8000],
            ['name' => 'Digital Sports Watch', 'min' => 1000, 'max' => 10000],
            ['name' => 'Wireless Earbuds', 'min' => 1200, 'max' => 18000],
        ];

        $product = fake()->randomElement($products);

        $name = $product['name'] . ' ' . fake()->numberBetween(1, 9999);

        $price = fake()->numberBetween(
            $product['min'],
            $product['max']
        );

        $hasSale = fake()->boolean(40);

        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'brand_id' => Brand::inRandomOrder()->value('id'),

            'name' => $name,
            'slug' => Str::slug($name),

            'sku' => 'SKU-' . strtoupper(
                fake()->unique()->bothify('??#####')
            ),

            'description' => fake()->randomElement([
                'Premium quality product designed for everyday use.',
                'A reliable product offering excellent performance and great value.',
                'Modern design combined with quality materials and dependable performance.',
                'Designed for comfort, durability and everyday convenience.',
                'A great choice for customers looking for quality at an affordable price.',
            ]),

            'price' => $price,

            'sale_price' => $hasSale
                ? round($price * fake()->randomFloat(2, 0.60, 0.90), 2)
                : null,

            'stock' => fake()->numberBetween(0, 250),

            'thumbnail' => null,

            'is_active' => fake()->boolean(95),

            'is_featured' => fake()->boolean(20),

            'sort_order' => fake()->numberBetween(1, 100),

            'seo_title' => $name . ' | Shopora',

            'seo_description' => 'Buy ' . $name . ' online at Shopora.',
        ];
    }
}
