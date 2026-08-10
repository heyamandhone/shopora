<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Apple',
            'Samsung',
            'Sony',
            'Dell',
            'HP',
            'Lenovo',
            'Asus',
            'Acer',
            'Nike',
            'Adidas',
            'Puma',
            'Reebok',
            'Levis',
            'Zara',
            'H&M',
            'LG',
            'Panasonic',
            'Boat',
            'JBL',
            'Canon',
            'Nikon',
            'OnePlus',
            'Xiaomi',
            'Realme',
            'Oppo',
            'Vivo',
            'Casio',
            'Titan',
            'Fastrack',
            'Philips',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'logo' => 'https://picsum.photos/300/300?random=' . fake()->numberBetween(1, 300),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 30),
            'seo_title' => $name,
            'seo_description' => fake()->sentence(),
        ];
    }
}
