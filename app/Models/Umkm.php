<?php

// app/Models/Umkm.php

namespace App\Models;

use Carbon\Carbon;
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
        'logo_url',
        'jam_buka',
        'jam_tutup',
    ];

    protected $casts = [
        'jam_buka' => 'datetime:H:i',
        'jam_tutup' => 'datetime:H:i',
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

    public function isOpenNow(): bool
    {
        if (!$this->jam_buka || !$this->jam_tutup) {
            return true;
        }

        $now = Carbon::now()->format('H:i:s');
        $open = Carbon::parse($this->jam_buka)->format('H:i:s');
        $close = Carbon::parse($this->jam_tutup)->format('H:i:s');

        if ($open <= $close) {
            return $now >= $open && $now <= $close;
        }

        return $now >= $open || $now <= $close;
    }
}
