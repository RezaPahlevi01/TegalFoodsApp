<?php

// app/Models/Umkm.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $table = 'umkms';

    protected $fillable = [
        'user_id',
        'nama_umkm',
        'nama_pemilik',
        'deskripsi',
        'nomor_whatsapp',
        'alamat',
        'logo_url'
    ];

    // Relasi: Satu UMKM memiliki BANYAK Makanan
    public function makanans()
    {
        return $this->hasMany(Makanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}