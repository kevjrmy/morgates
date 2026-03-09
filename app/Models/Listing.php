<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'photos',
        'price_per_night',
        'currency',
        'max_guests',
        'min_nights',
        'max_nights',
        'country',
        'city',
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'photos' => 'array',
    ];
}