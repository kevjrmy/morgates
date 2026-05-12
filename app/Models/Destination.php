<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'type',
        'region',
        'country',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function scopeSearch(Builder $query, string $term): Builder
    {
        $lower = mb_strtolower($term);
        return $query->whereRaw("LOWER(name) LIKE ?", ['%' . $lower . '%']);
    }

    public function scopeOrderedForSearch(Builder $query, string $term): Builder
    {
        $lower = mb_strtolower($term);

        return $query
            ->orderByRaw("CASE WHEN LOWER(name) = ? THEN 0 WHEN LOWER(name) LIKE ? THEN 1 ELSE 2 END", [$lower, $lower . '%'])
            ->orderByRaw("CASE WHEN type = 'city' THEN 0 ELSE 1 END");
    }
}
