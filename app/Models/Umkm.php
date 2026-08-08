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
        'latitude',
        'longitude',
        'logo_url',
        'jam_buka',
        'jam_tutup',
        'foto_qris',
    ];

    protected $casts = [];

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
        $openRaw = $this->getRawOriginal('jam_buka');
        $closeRaw = $this->getRawOriginal('jam_tutup');

        if (!$openRaw || !$closeRaw) {
            return true;
        }

        $now = Carbon::now('Asia/Jakarta');
        $open = Carbon::parse($openRaw, 'Asia/Jakarta');
        $close = Carbon::parse($closeRaw, 'Asia/Jakarta');

        if ($open->lessThan($close)) {
            return $now->between($open, $close);
        }

        return $now->gte($open) || $now->lte($close);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
