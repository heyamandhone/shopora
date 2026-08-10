<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'is_active',
        'email_verified_at',

    ];


    protected $casts = [

        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',

    ];


    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
