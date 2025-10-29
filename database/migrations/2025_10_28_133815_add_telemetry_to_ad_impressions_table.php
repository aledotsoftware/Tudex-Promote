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
            $table->string('page_url')->nullable()->after('impression_time');
            $table->string('user_agent')->nullable()->after('page_url');
            $table->json('metadata')->nullable()->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad_impressions', function (Blueprint $table) {
            $table->dropColumn(['page_url', 'user_agent', 'metadata']);
        });
    }
};
