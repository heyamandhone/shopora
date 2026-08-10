<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use SoftDeletes, HasFactory;


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
