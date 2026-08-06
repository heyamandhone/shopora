<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

it('renders the main storefront pages for authenticated users', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $category = Category::create([
        'name' => 'Electronics',
        'slug' => 'electronics',
        'description' => 'Test category',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'brand_id' => null,
        'name' => 'Test Laptop',
        'slug' => 'test-laptop',
        'sku' => 'TEST-001',
        'description' => 'A demo laptop',
        'price' => 999.99,
        'sale_price' => 899.99,
        'stock' => 20,
        'thumbnail' => '',
        'is_active' => true,
        'is_featured' => true,
        'sort_order' => 1,
        'seo_title' => 'Test Laptop',
        'seo_description' => 'Demo laptop',
    ]);

    $this->actingAs($user)
        ->get('/')->assertOk();

    $this->actingAs($user)
        ->get('/shop')->assertOk();

    $this->actingAs($user)
        ->get('/products/' . $product->slug)->assertOk();

    $this->actingAs($user)
        ->get('/account')->assertOk();
});
