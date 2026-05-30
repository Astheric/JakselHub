<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartCityMetric extends Model
{
    protected $fillable = [
        'aqi',
        'green_spaces_count',
        'public_transport_count',
    ];
}
