<?php

// app/Models/Makanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'umkm_id',
        'nama_makanan',
        'deskripsi',
        'harga',
        'gambar_url',
        'kategori',
    ];

    // Relasi: Satu Makanan dimiliki OLEH SATU UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}