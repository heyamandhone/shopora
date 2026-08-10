<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Electronics',
            'Mobiles',
            'Laptops',
            'Fashion',
            'Men Clothing',
            'Women Clothing',
            'Shoes',
            'Sports',
            'Books',
            'Beauty',
            'Furniture',
            'Home Decor',
            'Kitchen',
            'Toys',
            'Gaming',
            'Watches',
            'Jewellery',
            'Automotive',
            'Grocery',
            'Health',
        ]);

        return [
            'parent_id' => null,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'image' => 'https://picsum.photos/400/400?random=' . fake()->numberBetween(1, 500),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 20),
            'seo_title' => $name,
            'seo_description' => fake()->sentence(),
        ];
    }
}
