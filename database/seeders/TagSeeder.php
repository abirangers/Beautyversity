<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'skincare',
            'makeup',
            'tutorial',
            'tips',
            'review',
            'product',
        ];

        foreach ($tags as $name) {
            \App\Models\Tag::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => Str::title(str_replace('-', ' ', $name)),
                    'slug' => Str::slug($name),
                ]
            );
        }
    }
}

