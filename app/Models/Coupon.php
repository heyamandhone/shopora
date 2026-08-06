<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_amount',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];
}
