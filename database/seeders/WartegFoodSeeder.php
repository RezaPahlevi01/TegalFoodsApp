<?php

namespace Database\Seeders;

use App\Models\Makanan;
use App\Models\Umkm;
use Illuminate\Database\Seeder;

class WartegFoodSeeder extends Seeder
{
    public function run(): void
    {
        $umkm = Umkm::where('nama_umkm', 'like', '%warteg%')
            ->whereHas('user', fn ($q) => $q->where('name', 'like', '%SITI NURHIDAYAH%'))
            ->first();

        if (!$umkm) {
            $this->command?->error('UMKM warteg milik SITI NURHIDAYAH tidak ditemukan.');
            return;
        }

        $this->command?->info("Ditemukan: {$umkm->nama_umkm} (ID: {$umkm->id})");

        $makanan = [
            // LAUK PAUK
            ['nama_makanan' => 'Ayam Goreng',         'kategori' => 'Lauk Pauk', 'harga' => 12000, 'deskripsi' => 'Ayam goreng bumbu kunyit, digoreng renyah'],
            ['nama_makanan' => 'Ayam Bacem',           'kategori' => 'Lauk Pauk', 'harga' => 13000, 'deskripsi' => 'Ayam bacem manis khas Jawa, digoreng setengah kering'],
            ['nama_makanan' => 'Ayam Bakar',           'kategori' => 'Lauk Pauk', 'harga' => 14000, 'deskripsi' => 'Ayam bakar bumbu kecap manis'],
            ['nama_makanan' => 'Ikan Goreng',          'kategori' => 'Lauk Pauk', 'harga' => 10000, 'deskripsi' => 'Ikan nila goreng dengan bumbu kunyit'],
            ['nama_makanan' => 'Ikan Asin Goreng',     'kategori' => 'Lauk Pauk', 'harga' => 8000,  'deskripsi' => 'Ikan asin jambal roti goreng, gurih dan renyah'],
            ['nama_makanan' => 'Sambal Goreng Tempe',  'kategori' => 'Lauk Pauk', 'harga' => 7000,  'deskripsi' => 'Tempe iris goreng dengan sambal balado'],
            ['nama_makanan' => 'Tempe Goreng',         'kategori' => 'Lauk Pauk', 'harga' => 5000,  'deskripsi' => 'Tempe goreng tepung, renyah di luar lembut di dalam'],
            ['nama_makanan' => 'Tahu Goreng',          'kategori' => 'Lauk Pauk', 'harga' => 5000,  'deskripsi' => 'Tahu goreng tepung, cocok untuk lauk nasi'],
            ['nama_makanan' => 'Tahu Tempe Bacem',     'kategori' => 'Lauk Pauk', 'harga' => 7000,  'deskripsi' => 'Tahu dan tempe bacam bumbu manis khas Jawa'],
            ['nama_makanan' => 'Telur Dadar',          'kategori' => 'Lauk Pauk', 'harga' => 7000,  'deskripsi' => 'Telur dadar iris dengan irisan daun bawang'],
            ['nama_makanan' => 'Telur Balado',         'kategori' => 'Lauk Pauk', 'harga' => 8000,  'deskripsi' => 'Telur rebus balado pedas manis'],
            ['nama_makanan' => 'Telur Ceplok Balado',  'kategori' => 'Lauk Pauk', 'harga' => 8000,  'deskripsi' => 'Telur mata sapi ceplok dengan sambal balado'],
            ['nama_makanan' => 'Perkedel Kentang',     'kategori' => 'Lauk Pauk', 'harga' => 7000,  'deskripsi' => 'Perkedel kentang dengan isian daging cincang'],
            ['nama_makanan' => 'Sambal Goreng Kentang', 'kategori' => 'Lauk Pauk', 'harga' => 7000, 'deskripsi' => 'Kentang goreng dengan sambal merah pedas'],
            ['nama_makanan' => 'Kepala Ikan Bumbu Kuning', 'kategori' => 'Lauk Pauk', 'harga' => 12000, 'deskripsi' => 'Kepala ikan masak bumbu kuning khas Tegal'],
            ['nama_makanan' => 'Jengkol Balado',       'kategori' => 'Lauk Pauk', 'harga' => 9000,  'deskripsi' => 'Jengkol goreng balado pedas'],
            ['nama_makanan' => 'Paru Goreng',          'kategori' => 'Lauk Pauk', 'harga' => 12000, 'deskripsi' => 'Paru sapi goreng bumbu, empuk dan gurih'],
            ['nama_makanan' => 'Oseng-oseng Kikil',    'kategori' => 'Lauk Pauk', 'harga' => 10000, 'deskripsi' => 'Kikil sapi oseng dengan cabai hijau'],

            // SAYURAN
            ['nama_makanan' => 'Sayur Asem',           'kategori' => 'Sayuran', 'harga' => 6000, 'deskripsi' => 'Sayur asem segar dengan jagung, labu, dan kacang panjang'],
            ['nama_makanan' => 'Sayur Lodeh',          'kategori' => 'Sayuran', 'harga' => 6000, 'deskripsi' => 'Sayur lodeh santan dengan terong, kacang, dan melinjo'],
            ['nama_makanan' => 'Sayur Bayam',          'kategori' => 'Sayuran', 'harga' => 5000, 'deskripsi' => 'Sayur bayam bening dengan jagung manis'],
            ['nama_makanan' => 'Sayur Nangka',         'kategori' => 'Sayuran', 'harga' => 6000, 'deskripsi' => 'Sayur nangka muda (gori) santan khas Jawa'],
            ['nama_makanan' => 'Tumis Kangkung',       'kategori' => 'Sayuran', 'harga' => 5000, 'deskripsi' => 'Kangkung tumis bawang putih dan cabai'],
            ['nama_makanan' => 'Tumis Tauge',          'kategori' => 'Sayuran', 'harga' => 5000, 'deskripsi' => 'Tauge goreng tumis dengan tahu'],
            ['nama_makanan' => 'Gado-gado',            'kategori' => 'Sayuran', 'harga' => 8000, 'deskripsi' => 'Sayuran rebus dengan bumbu kacang'],

            // PENDAMPING
            ['nama_makanan' => 'Nasi Putih',           'kategori' => 'Pendamping', 'harga' => 5000, 'deskripsi' => 'Nasi putih pulen, porsi standar warteg'],
            ['nama_makanan' => 'Sambal Terasi',        'kategori' => 'Pendamping', 'harga' => 2000, 'deskripsi' => 'Sambal terasi ulek pedas, bikin nasi tambah'],
            ['nama_makanan' => 'Lalapan',              'kategori' => 'Pendamping', 'harga' => 3000, 'deskripsi' => 'Lalapan segar: timun, kemangi, dan kubis'],
            ['nama_makanan' => 'Kerupuk',              'kategori' => 'Pendamping', 'harga' => 2000, 'deskripsi' => 'Kerupuk udang atau kerupuk tempe'],
            ['nama_makanan' => 'Mie Goreng',           'kategori' => 'Pendamping', 'harga' => 8000, 'deskripsi' => 'Mie goreng telur bumbu kecap'],
            ['nama_makanan' => 'Bakmi Godog',          'kategori' => 'Pendamping', 'harga' => 9000, 'deskripsi' => 'Bakmi kuah dengan sayur dan telur'],

            // MINUMAN
            ['nama_makanan' => 'Es Teh Manis',         'kategori' => 'Minuman', 'harga' => 4000, 'deskripsi' => 'Teh manis dingin, segar'],
            ['nama_makanan' => 'Es Jeruk',             'kategori' => 'Minuman', 'harga' => 5000, 'deskripsi' => 'Jeruk peras segar es'],
            ['nama_makanan' => 'Es Kelapa Muda',       'kategori' => 'Minuman', 'harga' => 7000, 'deskripsi' => 'Air kelapa muda segar'],
            ['nama_makanan' => 'Kopi Hitam',           'kategori' => 'Minuman', 'harga' => 4000, 'deskripsi' => 'Kopi hitam kopi tubruk panas'],
        ];

        $count = 0;
        foreach ($makanan as $item) {
            Makanan::updateOrCreate(
                [
                    'umkm_id' => $umkm->id,
                    'nama_makanan' => $item['nama_makanan'],
                ],
                [
                    'kategori'     => $item['kategori'],
                    'harga'        => $item['harga'],
                    'deskripsi'    => $item['deskripsi'],
                    'gambar_url'   => null,
                    'is_available' => true,
                ]
            );
            $count++;
        }

        $this->command?->info("Berhasil insert/update {$count} produk makanan warteg.");
    }
}
