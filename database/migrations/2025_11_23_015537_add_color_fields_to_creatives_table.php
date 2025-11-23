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
        Schema::table('creatives', function (Blueprint $table) {
            $table->string('bg_color')->nullable()->default('#ffffff');
            $table->string('title_color')->nullable()->default('#0f172a');
            $table->string('text_color')->nullable()->default('#64748b');
            $table->string('button_color')->nullable()->default('#3b82f6');
            $table->string('border_color')->nullable()->default('#e2e8f0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn(['bg_color', 'title_color', 'text_color', 'button_color', 'border_color']);
        });
    }
};
