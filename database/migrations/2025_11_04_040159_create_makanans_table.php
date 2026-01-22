<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/..._create_makanans_table.php

    public function up(): void
    {
        Schema::create('makanans', function (Blueprint $table) {
            $table->id();

            // Ini adalah Kunci Asing (Foreign Key)
            // Menghubungkan makanan ini ke pemilik UMKM-nya
            $table->foreignId('umkm_id')
                ->constrained('umkms') // merujuk ke tabel 'umkms'
                ->onDelete('cascade'); // Jika UMKM dihapus, makanannya ikut terhapus

            $table->string('nama_makanan');
            $table->text('deskripsi'); // Untuk info bahan, asal-usul (kebutuhan chatbot)
            $table->integer('harga'); // (misal: 45000 untuk Rp 45.000)
            $table->string('gambar_url')->nullable();
            $table->string('kategori')->nullable(); // (misal: Makanan, Minuman)
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makanans');
    }
};
