<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('category')->nullable()->after('author');
            $table->text('tags')->nullable()->after('category');
            $table->text('excerpt')->nullable()->after('content');
            $table->string('post_type')->nullable()->after('tags'); // Tambahkan kolom post_type
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['category', 'tags', 'excerpt', 'post_type']);
        });
    }
};