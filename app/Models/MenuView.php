<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuView extends Model
{
    protected $fillable = [
        'umkm_id',
        'makanan_id',
        'session_id',
        'view_date',
        'ip_address',
        'user_agent',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }
}
