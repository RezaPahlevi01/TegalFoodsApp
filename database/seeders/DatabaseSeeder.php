<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder kita di sini
        $this->call([
            UmkmSeeder::class,
            MakananSeeder::class,
        ]);
    }
}