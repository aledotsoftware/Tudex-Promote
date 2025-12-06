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
        Schema::create('ad_impressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creative_id')->constrained()->onDelete('cascade');
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_zone_id')->constrained()->onDelete('cascade');
            $table->timestamp('impression_time')->nullable();
            $table->string('ip_hash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_impressions');
    }
};
