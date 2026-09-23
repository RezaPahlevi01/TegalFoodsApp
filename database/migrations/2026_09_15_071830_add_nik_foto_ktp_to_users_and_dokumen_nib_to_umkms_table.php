<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('name');
            $table->string('foto_ktp')->nullable()->after('nik');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->string('dokumen_nib')->nullable()->after('nib');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'foto_ktp']);
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('dokumen_nib');
        });
    }
};
