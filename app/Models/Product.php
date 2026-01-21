<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'discount_price',
        'stock',
        'status',
        'thumbnail',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'status' => 'integer',
    ];
}
