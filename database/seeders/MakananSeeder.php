<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Makanan; // <-- JANGAN LUPA IMPORT

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Makanan untuk UMKM ID 1 (Warung Sate Barokah)
        Makanan::create([
            'umkm_id' => 1,
            'nama_makanan' => 'Sate Kambing Muda (10 Tusuk)',
            'deskripsi' => 'Daging kambing muda pilihan, dibakar dengan bumbu kecap spesial.',
            'harga' => 45000,
            'gambar_url' => 'https://assets.unileversolutions.com/v1/126480230.png',
            'kategori' => 'Makanan Berat'
        ]);

        Makanan::create([
            'umkm_id' => 1,
            'nama_makanan' => 'Gule Kambing',
            'deskripsi' => 'Gule kaya rempah dengan daging kambing yang empuk.',
            'harga' => 30000,
            'gambar_url' => 'https://rajominang.id/blog/uploads/images/202407/image_750x_66828ef784999.jpg',
            'kategori' => 'Makanan Berat'
        ]);

        // Makanan untuk UMKM ID 2 (Ibu Khas Tegal)
        Makanan::create([
            'umkm_id' => 2,
            'nama_makanan' => 'Tahu Aci',
            'deskripsi' => 'Tahu kuning khas tegal dengan adonan aci gurih.',
            'harga' => 15000,
            'gambar_url' => 'https://www.bimoli.com/images/dapuribu/resep-tahu-aci-lezat-favorit-keluarga-bikin-yuk-moms_124818014_2.png',
            'kategori' => 'Camilan'
        ]);

        Makanan::create([
            'umkm_id' => 2,
            'nama_makanan' => 'Nasi Ponggol Setan',
            'deskripsi' => 'Nasi ponggol dengan sambal orek tempe super pedas.',
            'harga' => 12000,
            'gambar_url' => 'https://cdn.yummy.co.id/content-images/images/20230809/NwIJQKbkpSv3fVqJQr2fOpYoSqeqxgwB-31363931353937313930d41d8cd98f00b204e9800998ecf8427e.jpg?x-oss-process=image/resize,w_388,h_388,m_fixed,x-oss-process=image/format,webp',
            'kategori' => 'Makanan Berat'
        ]);
    }
}