<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'customer_id',
        'product_id',
        'quantity',
        'price',
        'options',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'options' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
