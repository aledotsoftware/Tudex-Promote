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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('title_color')->default('#1a0dab');
            $table->string('description_color')->default('#3c4043');
            $table->string('accent_color')->default('#1a73e8');
            $table->string('font_family')->default('Roboto, sans-serif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['title_color', 'description_color', 'accent_color', 'font_family']);
        });
    }
};
