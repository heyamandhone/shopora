<?php

use App\Models\User;

it('renders the shopping and reporting pages for authenticated users', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->get('/carts')
        ->assertOk();

    $this->actingAs($user)
        ->get('/wishlists')
        ->assertOk();

    $this->actingAs($user)
        ->get('/coupons')
        ->assertOk();

    $this->actingAs($user)
        ->get('/payments')
        ->assertOk();

    $this->actingAs($user)
        ->get('/reviews')
        ->assertOk();

    $this->actingAs($user)
        ->get('/reports')
        ->assertOk();
});
