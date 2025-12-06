<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Refactors creatives from storing raw HTML to storing components.
     * This allows dynamic format generation (wide, tall, square, etc.)
     */
    public function up(): void
    {
        Schema::table('creatives', function (Blueprint $table) {
            // Add component-based fields
            $table->string('title')->nullable()->after('campaign_id');
            $table->text('description')->nullable()->after('title');
            $table->string('button_text')->default('Learn More')->after('description');
            $table->string('image_url')->nullable()->after('button_text');
            
            // Remove type - format is now determined at display time
            $table->dropColumn('type');
            
            // Remove html_content - HTML is now generated dynamically
            $table->dropColumn('html_content');
            
            // Remove file_url - no longer used
            $table->dropColumn('file_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'button_text', 'image_url']);
            $table->string('type')->default('banner')->after('click_url');
            $table->text('html_content')->nullable()->after('click_url');
            $table->string('file_url')->nullable()->after('campaign_id');
        });
    }
};
