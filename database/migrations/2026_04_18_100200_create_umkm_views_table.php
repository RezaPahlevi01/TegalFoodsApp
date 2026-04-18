<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->cascadeOnDelete();
            $table->string('session_id');
            $table->date('view_date');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->unique(['umkm_id', 'session_id', 'view_date']);
            $table->index(['umkm_id', 'view_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_views');
    }
};
