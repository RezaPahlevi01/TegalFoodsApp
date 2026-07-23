<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MerchantTegalFoodSeeder extends Seeder
{
    public function run()
    {
        $csvPath = storage_path('app/tegalfood_schema_ready_real_emails.csv');
        
        if (!file_exists($csvPath)) {
            $this->command->error('File CSV tidak ditemukan di storage/app/');
            return;
        }

        $file = fopen($csvPath, 'r');
        fgetcsv($file); // Lewati header

        $this->command->info('Mulai mengimpor data UMKM TegalFood...');

        DB::beginTransaction();

        try {
            $countUsers = 0;
            $countUmkms = 0;
            $now = Carbon::now();
            $defaultPassword = Hash::make('password123');

            while (($data = fgetcsv($file, 3000, ",")) !== FALSE) {
                $name          = $data[0];
                $email         = $data[1];
                $nama_umkm     = $data[3];
                $nama_pemilik  = $data[4];
                $nomor_wa      = $data[5];
                $alamat        = $data[6];

                // 1. Cek apakah user dengan email ini sudah ada
                $existingUser = DB::table('users')->where('email', $email)->first();

                if ($existingUser) {
                    // Jika sudah ada, gunakan ID user tersebut
                    $userId = $existingUser->id;
                } else {
                    // Jika belum ada, buat user baru
                    $userId = DB::table('users')->insertGetId([
                        'name'       => $name,
                        'email'      => $email,
                        'password'   => $defaultPassword, // Menggunakan variabel agar hashing tidak berulang dan lebih cepat
                        'role'       => 'merchant',
                        'status'     => 'pending',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    $countUsers++;
                }

                // 2. Insert ke tabel public.umkms menggunakan userId (bisa jadi user baru atau user existing)
                DB::table('umkms')->insert([
                    'user_id'        => $userId,
                    'nama_umkm'      => $nama_umkm,
                    'nama_pemilik'   => $nama_pemilik,
                    'nomor_whatsapp' => $nomor_wa,
                    'alamat'         => $alamat,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);
                $countUmkms++;
            }

            DB::commit();
            $this->command->info("Selesai! Berhasil membuat {$countUsers} Akun User dan mengimpor {$countUmkms} data UMKM.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Terjadi kesalahan saat import: " . $e->getMessage());
        }

        fclose($file);
    }
}