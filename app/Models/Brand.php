<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'is_active',
        'sort_order',
        'seo_title',
        'seo_description',
    ];


    protected $casts = [
        'is_active' => 'boolean',
    ];
}
