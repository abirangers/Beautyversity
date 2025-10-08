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
        // Create sample articles
        \App\Models\Article::updateOrCreate(
            ['title' => 'Getting Started with Laravel'],
            [
                'title' => 'Getting Started with Laravel',
                'content' => 'Laravel is a powerful PHP framework that makes web development easier and more enjoyable. In this article, we\'ll cover the basics of Laravel including routing, middleware, and Eloquent ORM.',
                'thumbnail' => 'default-article.jpg',
                'author' => 'Jane Smith',
            ]
        );
        
        \App\Models\Article::updateOrCreate(
            ['title' => 'Understanding PHP Security Best Practices'],
            [
                'title' => 'Understanding PHP Security Best Practices',
                'content' => 'Security is crucial when developing web applications. This article explores common security vulnerabilities in PHP applications and how to prevent them.',
                'thumbnail' => 'default-article.jpg',
                'author' => 'John Doe',
            ]
        );
    }
}
