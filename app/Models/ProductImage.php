<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [

        'product_id',
        'image',
        'alt_text',
        'is_primary',
        'sort_order',

    ];


    protected $casts = [

        'is_primary' => 'boolean',

    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
