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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'otp_code')) {
                $table->string('otp_code', 6)->nullable()->after('role');
            }

            if (!Schema::hasColumn('users', 'otp_expired_at')) {
                $table->timestamp('otp_expired_at')->nullable()->after('otp_code');
            }

            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('otp_expired_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('users', 'google_id')) {
                $columnsToDrop[] = 'google_id';
            }

            if (Schema::hasColumn('users', 'otp_expired_at')) {
                $columnsToDrop[] = 'otp_expired_at';
            }

            if (Schema::hasColumn('users', 'otp_code')) {
                $columnsToDrop[] = 'otp_code';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
