<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('nama_penerima')
                ->nullable()
                ->after('user_id');

            $table->string('nomor_telepon')
                ->nullable()
                ->after('nama_penerima');

            $table->enum('metode_pengiriman', [
                'delivery',
                'pickup'
            ])->default('delivery')->after('nomor_telepon');

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'nama_penerima',
                'nomor_telepon',
                'metode_pengiriman'
            ]);

        });
    }
};