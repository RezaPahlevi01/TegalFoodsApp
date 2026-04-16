<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthFeatureTestSeeder extends Seeder
{
    public function run(): void
    {
        $pendingUmkm = User::updateOrCreate(
            ['email' => 'umkm.pending@test.com'],
            [
                'name' => 'UMKM Pending',
                'password' => Hash::make('password123'),
                'role' => 'umkm',
                'status' => 'pending',
                'otp_code' => '123456',
                'otp_expired_at' => Carbon::now()->addMinutes(10),
                'google_id' => null,
                'email_verified_at' => null,
            ]
        );

        Umkm::updateOrCreate(
            ['user_id' => $pendingUmkm->id],
            [
                'nama_umkm' => 'Warung Pending',
                'nama_pemilik' => 'UMKM Pending',
                'nomor_whatsapp' => '081111111111',
                'alamat' => 'Jl. Pending No. 1',
                'deskripsi' => 'Akun untuk test alur OTP pending',
            ]
        );

        $activeUmkm = User::updateOrCreate(
            ['email' => 'umkm.active@test.com'],
            [
                'name' => 'UMKM Active',
                'password' => Hash::make('password123'),
                'role' => 'umkm',
                'status' => 'active',
                'otp_code' => null,
                'otp_expired_at' => null,
                'google_id' => null,
                'email_verified_at' => Carbon::now(),
            ]
        );

        Umkm::updateOrCreate(
            ['user_id' => $activeUmkm->id],
            [
                'nama_umkm' => 'Warung Active',
                'nama_pemilik' => 'UMKM Active',
                'nomor_whatsapp' => '082222222222',
                'alamat' => 'Jl. Active No. 2',
                'deskripsi' => 'Akun untuk test login UMKM aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin.google.conflict@test.com'],
            [
                'name' => 'Admin Conflict',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
                'google_id' => null,
                'otp_code' => null,
                'otp_expired_at' => null,
                'email_verified_at' => Carbon::now(),
            ]
        );
    }
}
