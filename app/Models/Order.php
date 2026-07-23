<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'umkm_id',
        'kode_order',

        'nama_penerima',
        'nomor_telepon',
        'alamat_pengiriman',
        'metode_pengiriman',

        'subtotal',
        'ongkir',
        'total',
        'status',
        'metode_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    }