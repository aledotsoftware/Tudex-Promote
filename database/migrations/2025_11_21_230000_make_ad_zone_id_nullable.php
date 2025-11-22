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
        // Make ad_zone_id nullable in all related tables
        Schema::table('placements', function (Blueprint $table) {
            $table->foreignId('ad_zone_id')->nullable()->change();
        });
        Schema::table('ad_impressions', function (Blueprint $table) {
            $table->foreignId('ad_zone_id')->nullable()->change();
        });
        Schema::table('ad_clicks', function (Blueprint $table) {
            $table->foreignId('ad_zone_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We cannot easily revert to non-nullable without data loss if nulls were introduced
    }
};
