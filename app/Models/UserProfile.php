<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [

        'user_id',

        'nama_lengkap',

        'nomor_telepon',

        'alamat',

        'latitude',

        'longitude'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}