<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check");

        DB::statement("
            ALTER TABLE orders
            ALTER COLUMN status TYPE varchar(30)
            USING status::varchar(30)
        ");

        DB::statement("
            ALTER TABLE orders
            ALTER COLUMN status SET DEFAULT 'pending_confirmation'
        ");

        DB::statement("
            UPDATE orders SET status = 'pending' WHERE status = 'pending_confirmation'
        ");

        Schema::table('orders', function (Blueprint $table) {
            $table->text('alasan_penolakan')->nullable()->after('status');
            $table->timestamp('confirmed_at')->nullable()->after('alasan_penolakan');
            $table->timestamp('paid_at')->nullable()->after('confirmed_at');
            $table->timestamp('processed_at')->nullable()->after('paid_at');
            $table->timestamp('completed_at')->nullable()->after('processed_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'alasan_penolakan',
                'confirmed_at',
                'paid_at',
                'processed_at',
                'completed_at',
            ]);
        });

        DB::statement("
            ALTER TABLE orders
            ALTER COLUMN status TYPE varchar(20)
            USING status::varchar(20)
        ");
    }
};
