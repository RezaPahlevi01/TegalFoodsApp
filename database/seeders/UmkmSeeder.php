<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm; // <-- Jangan lupa import Model

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        Umkm::create([
            'nama_umkm' => 'Warung Sate Barokah',
            'nama_pemilik' => 'Pak Ahmad',
            'deskripsi' => 'Spesialis Sate Kambing Muda dan Gule. Asli Tegal.',
            'nomor_whatsapp' => '6281234567890',
            'alamat' => 'Jl. Merdeka No. 1, Tegal',
            'logo_url' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1974&auto=format&fit=crop'
        ]);

        Umkm::create([
            'nama_umkm' => 'Ibu Khas Tegal',
            'nama_pemilik' => 'Ibu Siti',
            'deskripsi' => 'Menyediakan aneka Nasi Ponggol, Tahu Aci, dan lainnya.',
            'nomor_whatsapp' => '6281200001111',
            'alamat' => 'Pasar Pagi Tegal',
            'logo_url' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1981&auto=format&fit=crop'
        ]);
    }
}