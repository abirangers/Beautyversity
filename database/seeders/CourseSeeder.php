<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample courses
        \App\Models\Course::updateOrCreate(
            ['title' => 'Introduction to Web Development'],
            [
                'title' => 'Introduction to Web Development',
                'instructor' => 'John Doe',
                'description' => 'Learn the basics of web development including HTML, CSS, and JavaScript.',
                'price' => 500000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['dQw4w9WgXcQ', 'dQw4w9WgXcR']),
                'category' => 'Web Development',
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Advanced Laravel Techniques'],
            [
                'title' => 'Advanced Laravel Techniques',
                'instructor' => 'Jane Smith',
                'description' => 'Master advanced Laravel concepts including Eloquent, Artisan commands, and more.',
                'price' => 7500,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['dQw4w9WgXcQ', 'dQw4w9WgXcR', 'dQw4w9WgXcS']),
                'category' => 'PHP Framework',
                'level' => 'Advanced',
            ]
        );
    }
}
