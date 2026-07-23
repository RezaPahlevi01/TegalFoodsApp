<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'umkm_id',
        'makanan_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }
}