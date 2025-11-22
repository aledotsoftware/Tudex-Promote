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
            $table->longText('html_content')->nullable()->after('type');
            $table->string('file_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creatives', function (Blueprint $table) {
            $table->dropColumn('html_content');
            $table->string('file_url')->nullable(false)->change();
        });
    }
};
