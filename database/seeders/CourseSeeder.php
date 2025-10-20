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
        $categoryIds = \App\Models\CourseCategory::pluck('id', 'slug');

        // Create sample cosmetic-related courses
        \App\Models\Course::updateOrCreate(
            ['slug' => 'basic-skincare-routine-from-zero-to-hero'],
            [
                'title' => 'Basic Skincare Routine: From Zero to Hero',
                'instructor' => 'Dr. Amanda Larasati',
                'description' => 'Pelajari dasar-dasar membangun rutinitas skincare yang efektif untuk semua jenis kulit. Dari cara membersihkan wajah dengan benar hingga pentingnya sunscreen, kelas ini adalah panduan lengkap untuk pemula.',
                'price' => 150000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'u-kE8gRENqI',
                'course_category_id' => $categoryIds['skincare'] ?? null,
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'mengenal-bahan-skincare-retinol-aha-bha'],
            [
                'title' => 'Mengenal Bahan Skincare: Retinol, AHA, BHA',
                'instructor' => 'Dr. Sarah Wijaya',
                'description' => 'Pahami perbedaan dan manfaat bahan-bahan aktif dalam skincare seperti retinol, AHA, dan BHA. Pelajari cara penggunaan yang aman dan efektif untuk hasil maksimal.',
                'price' => 180000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['skincare'] ?? null,
                'level' => 'Intermediate',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'makeup-artistry-dasar-dasar-makeup'],
            [
                'title' => 'Makeup Artistry: Dasar-dasar Makeup',
                'instructor' => 'Diana Kartika',
                'description' => 'Kuasai teknik dasar makeup untuk tampil cantik sehari-hari. Dari base makeup hingga blending yang sempurna, cocok untuk pemula.',
                'price' => 200000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['makeup'] ?? null,
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'hair-care-perawatan-rambut-kering-dan-rusak'],
            [
                'title' => 'Hair Care: Perawatan Rambut Kering dan Rusak',
                'instructor' => 'Dr. Rina Setiawan',
                'description' => 'Pelajari cara merawat rambut kering dan rusak dengan produk dan teknik yang tepat. Termasuk perawatan di rumah dan di salon.',
                'price' => 120000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['hair-care'] ?? null,
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'anti-aging-skincare-lawan-tanda-tanda-penuaan'],
            [
                'title' => 'Anti-Aging Skincare: Lawan Tanda-tanda Penuaan',
                'instructor' => 'Dr. Michael Tanuwijaya',
                'description' => 'Kenali bahan-bahan anti-aging terbaik dan cara membangun rutinitas skincare untuk melawan tanda-tanda penuaan seperti kerutan dan bintik usia.',
                'price' => 250000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['skincare'] ?? null,
                'level' => 'Advanced',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'natural-beauty-makeup-dengan-bahan-alami'],
            [
                'title' => 'Natural Beauty: Makeup dengan Bahan Alami',
                'instructor' => 'Maya Sari',
                'description' => 'Buat tampilan natural dan sehat dengan makeup berbahan alami. Pelajari cara membuat produk makeup sendiri dari bahan-bahan rumahan.',
                'price' => 160000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['makeup'] ?? null,
                'level' => 'Intermediate',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'sunscreen-panduan-lengkap-perlindungan-uv'],
            [
                'title' => 'Sunscreen: Panduan Lengkap Perlindungan UV',
                'instructor' => 'Dr. Fitriani Kusuma',
                'description' => 'Pahami pentingnya sunscreen dan cara memilih produk yang tepat untuk jenis kulitmu. Pelajari juga cara aplikasi yang benar.',
                'price' => 100000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['skincare'] ?? null,
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['slug' => 'color-theory-dalam-makeup'],
            [
                'title' => 'Color Theory dalam Makeup',
                'instructor' => 'Bella Anggraini',
                'description' => 'Pelajari teori warna dalam makeup untuk menciptakan look yang harmonis. Dari warna kulit hingga warna mata, semuanya akan dibahas secara mendalam.',
                'price' => 220000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'course_category_id' => $categoryIds['makeup'] ?? null,
                'level' => 'Advanced',
            ]
        );
    }
}
