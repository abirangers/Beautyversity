<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_matching_courses_and_articles()
    {
        $category = CourseCategory::create([
            'name' => 'Pemrograman',
            'slug' => 'pemrograman',
            'description' => 'Belajar coding',
        ]);

        $course = Course::create([
            'title' => 'Laravel Fundamentals',
            'instructor' => 'Jane Doe',
            'description' => 'Belajar dasar framework Laravel untuk pengembangan web modern.',
            'price' => 250000,
            'thumbnail' => 'courses/laravel.jpg',
            'trailer_video_id' => 'abc123',
            'full_video_ids' => ['def456'],
            'course_category_id' => $category->id,
            'level' => 'Beginner',
        ]);

        $article = Article::create([
            'title' => 'Tips Produktif Menggunakan Laravel',
            'content' => 'Laravel membuat proses pengembangan menjadi lebih cepat dan menyenangkan.',
            'thumbnail' => 'articles/laravel-tips.jpg',
            'author' => 'John Smith',
            'excerpt' => 'Gunakan tips ini untuk meningkatkan produktivitas dengan Laravel.',
            'post_type' => 'post',
        ]);

        $response = $this->get(route('search', ['q' => 'Laravel']));

        $response->assertStatus(200);
        $response->assertSeeText('Laravel Fundamentals');
        $response->assertSeeText('Tips Produktif Menggunakan Laravel');
    }

    public function test_it_shows_empty_state_when_no_results_found()
    {
        $response = $this->get(route('search', ['q' => 'Nonexistent']));

        $response->assertStatus(200);
        $response->assertSee('Tidak ada kelas yang cocok dengan pencarian', false);
        $response->assertSee('Tidak ada artikel yang cocok dengan pencarian', false);
    }
}
