<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Getting Started with Laravel',
                'author' => 'Jane Smith',
                'excerpt' => 'Dasar-dasar framework Laravel untuk pengembang web pemula.',
                'content' => 'Laravel adalah framework PHP yang membuat pengembangan web menjadi lebih menyenangkan. Artikel ini membahas routing, middleware, dan Eloquent ORM.',
                'categories' => ['skincare-tips', 'wellness'],
                'tags' => ['tutorial', 'tips'],
            ],
            [
                'title' => 'Understanding PHP Security Best Practices',
                'author' => 'John Doe',
                'excerpt' => 'Panduan cepat untuk mengamankan aplikasi PHP dari celah umum.',
                'content' => 'Keamanan adalah hal penting saat mengembangkan aplikasi web. Artikel ini membahas kerentanan umum pada aplikasi PHP dan cara mencegahnya.',
                'categories' => ['product-review'],
                'tags' => ['tips', 'review'],
            ],
        ];

        foreach ($articles as $data) {
            $article = \App\Models\Article::updateOrCreate(
                ['title' => $data['title']],
                [
                    'title' => $data['title'],
                    'author' => $data['author'],
                    'excerpt' => $data['excerpt'],
                    'content_format' => 'wordpress',
                    'content' => $data['content'],
                    'thumbnail' => 'default-article.jpg',
                    'post_type' => 'post',
                ]
            );

            $categoryIds = \App\Models\ArticleCategory::whereIn('slug', $data['categories'])->pluck('id');
            $tagIds = \App\Models\Tag::whereIn('slug', $data['tags'])->pluck('id');

            $article->categories()->sync($categoryIds);
            $article->tags()->sync($tagIds);
        }
    }
}
