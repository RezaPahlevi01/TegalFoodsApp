<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $table = 'shipping_settings';

    protected $fillable = [
        'base_fare',
        'price_per_km',
        'minimum_fare',
        'maximum_fare',
        'rounding',
    ];

    protected $casts = [
        'base_fare'    => 'decimal:2',
        'price_per_km' => 'decimal:2',
        'minimum_fare' => 'decimal:2',
        'maximum_fare' => 'decimal:2',
        'rounding'     => 'integer',
    ];

    public static function instance(): static
    {
        return static::firstOrFail();
    }
}
