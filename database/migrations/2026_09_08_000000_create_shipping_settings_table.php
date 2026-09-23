<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_fare', 12, 2)->default(5000);
            $table->decimal('price_per_km', 12, 2)->default(2000);
            $table->decimal('minimum_fare', 12, 2)->default(5000);
            $table->decimal('maximum_fare', 12, 2)->default(30000);
            $table->integer('rounding')->default(500);
            $table->timestamps();
        });

        DB::table('shipping_settings')->insert([
            'base_fare'       => 5000,
            'price_per_km'    => 2000,
            'minimum_fare'    => 5000,
            'maximum_fare'    => 30000,
            'rounding'        => 500,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};
