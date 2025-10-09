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
        // Create sample cosmetic-related courses
        \App\Models\Course::updateOrCreate(
            ['title' => 'Basic Skincare Routine: From Zero to Hero'],
            [
                'title' => 'Basic Skincare Routine: From Zero to Hero',
                'instructor' => 'Dr. Amanda Larasati',
                'description' => 'Pelajari dasar-dasar membangun rutinitas skincare yang efektif untuk semua jenis kulit. Dari cara membersihkan wajah dengan benar hingga pentingnya sunscreen, kelas ini adalah panduan lengkap untuk pemula.',
                'price' => 150000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'u-kE8gRENqI',
                'full_video_ids' => json_encode(['abc1', 'def2', 'ghi3']),
                'category' => 'Skincare',
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Mengenal Bahan Skincare: Retinol, AHA, BHA'],
            [
                'title' => 'Mengenal Bahan Skincare: Retinol, AHA, BHA',
                'instructor' => 'Dr. Sarah Wijaya',
                'description' => 'Pahami perbedaan dan manfaat bahan-bahan aktif dalam skincare seperti retinol, AHA, dan BHA. Pelajari cara penggunaan yang aman dan efektif untuk hasil maksimal.',
                'price' => 180000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['jkl4', 'mno5', 'pqr6', 'stu7']),
                'category' => 'Skincare',
                'level' => 'Intermediate',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Makeup Artistry: Dasar-dasar Makeup'],
            [
                'title' => 'Makeup Artistry: Dasar-dasar Makeup',
                'instructor' => 'Diana Kartika',
                'description' => 'Kuasai teknik dasar makeup untuk tampil cantik sehari-hari. Dari base makeup hingga blending yang sempurna, cocok untuk pemula.',
                'price' => 200000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['vwx8', 'yz9', 'abc10', 'def11']),
                'category' => 'Makeup',
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Hair Care: Perawatan Rambut Kering dan Rusak'],
            [
                'title' => 'Hair Care: Perawatan Rambut Kering dan Rusak',
                'instructor' => 'Dr. Rina Setiawan',
                'description' => 'Pelajari cara merawat rambut kering dan rusak dengan produk dan teknik yang tepat. Termasuk perawatan di rumah dan di salon.',
                'price' => 120000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['ghi12', 'jkl13', 'mno14']),
                'category' => 'Hair Care',
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Anti-Aging Skincare: Lawan Tanda-tanda Penuaan'],
            [
                'title' => 'Anti-Aging Skincare: Lawan Tanda-tanda Penuaan',
                'instructor' => 'Dr. Michael Tanuwijaya',
                'description' => 'Kenali bahan-bahan anti-aging terbaik dan cara membangun rutinitas skincare untuk melawan tanda-tanda penuaan seperti kerutan dan bintik usia.',
                'price' => 250000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['pqr15', 'stu16', 'vwx17', 'yz18', 'abc19']),
                'category' => 'Skincare',
                'level' => 'Advanced',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Natural Beauty: Makeup dengan Bahan Alami'],
            [
                'title' => 'Natural Beauty: Makeup dengan Bahan Alami',
                'instructor' => 'Maya Sari',
                'description' => 'Buat tampilan natural dan sehat dengan makeup berbahan alami. Pelajari cara membuat produk makeup sendiri dari bahan-bahan rumahan.',
                'price' => 160000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['def20', 'ghi21', 'jkl22']),
                'category' => 'Makeup',
                'level' => 'Intermediate',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Sunscreen: Panduan Lengkap Perlindungan UV'],
            [
                'title' => 'Sunscreen: Panduan Lengkap Perlindungan UV',
                'instructor' => 'Dr. Fitriani Kusuma',
                'description' => 'Pahami pentingnya sunscreen dan cara memilih produk yang tepat untuk jenis kulitmu. Pelajari juga cara aplikasi yang benar.',
                'price' => 100000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['mno23', 'pqr24']),
                'category' => 'Skincare',
                'level' => 'Beginner',
            ]
        );
        
        \App\Models\Course::updateOrCreate(
            ['title' => 'Color Theory dalam Makeup'],
            [
                'title' => 'Color Theory dalam Makeup',
                'instructor' => 'Bella Anggraini',
                'description' => 'Pelajari teori warna dalam makeup untuk menciptakan look yang harmonis. Dari warna kulit hingga warna mata, semuanya akan dibahas secara mendalam.',
                'price' => 220000,
                'thumbnail' => 'default-course.jpg',
                'trailer_video_id' => 'dQw4w9WgXcQ',
                'full_video_ids' => json_encode(['stu25', 'vwx26', 'yz27', 'abc28']),
                'category' => 'Makeup',
                'level' => 'Advanced',
            ]
        );
    }
}
