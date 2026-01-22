<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/..._create_umkms_table.php

    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_umkm');
            $table->string('nama_pemilik');
            $table->text('deskripsi')->nullable();
            $table->string('nomor_whatsapp'); // Penting untuk proposal Anda
            $table->string('alamat')->nullable();
            $table->string('logo_url')->nullable(); // Untuk foto/logo UMKM
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
