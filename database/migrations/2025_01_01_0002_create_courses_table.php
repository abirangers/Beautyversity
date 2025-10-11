<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('instructor');
            $table->text('description');
            $table->integer('price');
            $table->string('thumbnail')->default('default-course.jpg');
            $table->string('trailer_video_id');
            $table->json('full_video_ids')->nullable();
            $table->unsignedBigInteger('course_category_id');
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->timestamps();

            $table->foreign('course_category_id')
                ->references('id')->on('course_categories')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
