<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'address',
        'latitude',
        'longitude',
        'image_path',
        'mrt_integrated',
        'walkable',
    ];

    protected $casts = [
        'mrt_integrated' => 'boolean',
        'walkable' => 'boolean',
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });

        static::updating(function ($destination) {
            $destination->slug = Str::slug($destination->name);
        });
    }
}
