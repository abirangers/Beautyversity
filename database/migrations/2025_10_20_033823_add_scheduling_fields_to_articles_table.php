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
        Schema::table('articles', function (Blueprint $table) {
            $table->datetime('scheduled_at')->nullable()->after('updated_at');
            $table->enum('status', ['draft', 'scheduled', 'published'])->default('draft')->after('scheduled_at');
            $table->datetime('published_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'status', 'published_at']);
        });
    }
};
