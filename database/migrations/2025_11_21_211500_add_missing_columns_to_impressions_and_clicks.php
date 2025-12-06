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
        Schema::table('ad_impressions', function (Blueprint $table) {
            $table->foreignId('placement_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('ad_clicks', function (Blueprint $table) {
            $table->foreignId('placement_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('click_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad_impressions', function (Blueprint $table) {
            $table->dropForeign(['placement_id']);
            $table->dropColumn(['placement_id']);
        });

        Schema::table('ad_clicks', function (Blueprint $table) {
            $table->dropForeign(['placement_id']);
            $table->dropColumn(['placement_id', 'click_time']);
        });
    }
};
