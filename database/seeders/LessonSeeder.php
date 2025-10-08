<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Course;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Module 1
            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Pendahuluan Dasar',
                'youtube_video_id' => 'N81-p51W_v4',
                'module' => 'Modul 1: Pendahuluan Dasar',
                'order' => 1,
                'duration' => '10:00',
                'is_preview' => true,
            ]);

            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Freelance di tahun 2025',
                'youtube_video_id' => 'N81-p51W_v4',
                'module' => 'Modul 1: Pendahuluan Dasar',
                'order' => 2,
                'duration' => '15:00',
                'is_preview' => false,
            ]);

            // Module 2
            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Intro',
                'youtube_video_id' => 'N81-p51W_v4',
                'module' => 'Modul 2: Persiapan Menjadi Web Developer',
                'order' => 1,
                'duration' => '12:00',
                'is_preview' => false,
            ]);

            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Jalur Coding Vs Jalur Wordpress',
                'youtube_video_id' => 'N81-p51W_v4',
                'module' => 'Modul 2: Persiapan Menjadi Web Developer',
                'order' => 2,
                'duration' => '18:00',
                'is_preview' => false,
            ]);
        }
    }
}
