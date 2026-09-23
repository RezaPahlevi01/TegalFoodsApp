<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            if (!Schema::hasColumn('umkms', 'nib')) {
                $table->string('nib')->nullable()->after('user_id');
            }
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->unique('user_id');
            $table->unique('nib');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
            $table->dropUnique(['nib']);
            $table->dropColumn('nib');
        });
    }
};
