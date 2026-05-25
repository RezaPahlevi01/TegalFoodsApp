<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $tables = [
            'users',
            'umkms',
            'makanans',
            'food_blogs',
            'sliders',
            'web_visits',
            'article_views',
            'umkm_views',
            'menu_views',
        ];

        foreach ($tables as $table) {
            $sequence = DB::selectOne("SELECT pg_get_serial_sequence('{$table}', 'id') AS seq");
            $sequenceName = $sequence?->seq ?? null;

            if (!$sequenceName) {
                continue;
            }

            DB::statement(
                "SELECT setval('{$sequenceName}', COALESCE((SELECT MAX(id) FROM {$table}), 1), (SELECT EXISTS (SELECT 1 FROM {$table})))"
            );
        }
    }

    public function down(): void
    {
        // No rollback needed for sequence sync operation.
    }
};
