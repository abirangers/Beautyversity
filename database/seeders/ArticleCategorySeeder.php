<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Skincare Tips',
            'Makeup Tutorial',
            'Product Review',
            'Hair Care',
            'Wellness',
        ];

        foreach ($categories as $name) {
            \App\Models\ArticleCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'slug' => Str::slug($name),
                ]
            );
        }
    }
}

