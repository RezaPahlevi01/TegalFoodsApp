<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('kode_order')->unique();

            $table->decimal('subtotal', 12, 2)->default(0);

            $table->decimal('ongkir', 12, 2)->default(0);

            $table->decimal('total', 12, 2)->default(0);

            $table->enum('status', [
                'pending',
                'dibayar',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('pending');

            $table->string('metode_pembayaran')->nullable();

            $table->text('alamat_pengiriman');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
