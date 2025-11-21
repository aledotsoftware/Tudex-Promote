<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE ad_zones MODIFY width INT NULL');
            DB::statement('ALTER TABLE ad_zones MODIFY height INT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE ad_zones ALTER COLUMN width DROP NOT NULL');
            DB::statement('ALTER TABLE ad_zones ALTER COLUMN height DROP NOT NULL');
        } else {
            // SQLite and others: fallback - attempt schema change via rename table approach
            // If this fails in some environments, the developer can run the appropriate
            // SQL for their database or install doctrine/dbal to use the fluent ->change().
            
            // No-op for sqlite in this migration to avoid destructive operations.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE ad_zones MODIFY width INT NOT NULL');
            DB::statement('ALTER TABLE ad_zones MODIFY height INT NOT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE ad_zones ALTER COLUMN width SET NOT NULL');
            DB::statement('ALTER TABLE ad_zones ALTER COLUMN height SET NOT NULL');
        } else {
            // No-op for sqlite/others
        }
    }
};
