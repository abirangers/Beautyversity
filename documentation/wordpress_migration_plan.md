# Rencana Migrasi Artikel WordPress ke Laravel

## Ringkasan

Dokumen ini menjelaskan rencana migrasi artikel dari WordPress ke aplikasi Laravel Kelas Digital. Proses ini mencakup migrasi konten artikel, gambar, dan metadata terkait.

## Tujuan

-   Memindahkan semua artikel dari database WordPress ke database Laravel
-   Memindahkan semua gambar artikel dari sistem file WordPress ke sistem file Laravel
-   Memastikan semua URL gambar dalam konten artikel diperbarui
-   Menjaga integritas data dan struktur informasi

## Lingkup

-   Migrasi data artikel (judul, konten, penulis, tanggal pembuatan, dll.)
-   Migrasi gambar artikel (gambar fitur dan gambar inline dalam konten)
-   Migrasi metadata artikel (kategori, tag)
-   Pembaruan struktur database Laravel untuk mendukung data WordPress

## Prasyarat

-   Akses ke database WordPress (untuk membaca data)
-   Akses ke direktori upload WordPress (untuk mengambil gambar)
-   Konfigurasi database Laravel siap digunakan
-   Pengetahuan tentang struktur database WordPress

## Struktur Database WordPress yang Terlibat

-   `wp_posts` - Menyimpan artikel (post_type = 'post')
-   `wp_postmeta` - Menyimpan metadata artikel (termasuk ID gambar fitur)
-   `wp_term_relationships`, `wp_term_taxonomy`, `wp_terms` - Menyimpan kategori dan tag
-   `wp_users` - Menyimpan informasi penulis

## Struktur Database Laravel yang Terlibat

-   `articles` - Tabel yang akan menyimpan artikel
-   `users` - Tabel yang menyimpan informasi penulis (jika diperlukan)

## Rencana Langkah-demi-Langkah

### Fase 1: Persiapan dan Analisis

1. **Analisis Struktur Data**

    - Analisis struktur tabel `wp_posts` untuk memahami field-field penting
    - Identifikasi field yang perlu dipetakan ke tabel `articles`
    - Dokumentasikan struktur gambar dan metadata dalam WordPress

2. **Evaluasi Struktur Artikel Laravel Saat Ini**

    - Tinjau skema tabel `articles` yang ada
    - Identifikasi field tambahan yang mungkin diperlukan (kategori, tag, excerpt)
    - Buat daftar perubahan struktur database yang diperlukan

3. **Konfigurasi Koneksi Database WordPress**
    - Tambahkan konfigurasi koneksi database WordPress ke `config/database.php`
    - Pastikan koneksi dapat diakses dari Laravel

### Fase 2: Perubahan Struktur Database

4. **Buat Migration untuk Memperluas Tabel Articles**

    - Tambahkan kolom `category`, `tags`, dan `excerpt` jika belum ada
    - Pastikan tipe data sesuai dengan data WordPress

5. **Update Model Article**
    - Tambahkan field baru ke `$fillable` dalam model `App\Models\Article`
    - Tambahkan accessor/mutator jika diperlukan

### Fase 3: Pembuatan Alat Migrasi

6. **Buat Command Artisan untuk Migrasi**

    - Buat command: `php artisan make:command MigrateWordPressArticles`
    - Implementasikan logika migrasi dalam command tersebut

7. **Implementasi Fungsi-Fungsi Migrasi**
    - Fungsi untuk mengambil artikel dari WordPress
    - Fungsi untuk mengunduh dan menyimpan gambar
    - Fungsi untuk memproses konten artikel
    - Fungsi untuk menyimpan artikel ke database Laravel

### Fase 4: Penanganan Gambar

8. **Implementasi Download dan Penyimpanan Gambar**

    - Download gambar fitur dari WordPress dan simpan ke `storage/app/public/articles/`
    - Proses gambar inline dalam konten artikel
    - Update URL gambar dalam konten artikel

9. **Validasi dan Backup Gambar**
    - Buat backup gambar WordPress sebelum migrasi
    - Validasi bahwa semua gambar berhasil diunduh

### Fase 5: Eksekusi Migrasi

10. **Uji Coba di Lingkungan Development**

    -   Jalankan migrasi pada dataset kecil
    -   Verifikasi bahwa data dan gambar berhasil dipindahkan
    -   Perbaiki masalah yang ditemukan

11. **Migrasi Produksi**
    -   Backup database dan file WordPress sebelum migrasi
    -   Jalankan migrasi secara penuh
    -   Verifikasi hasil migrasi

### Fase 6: Validasi dan Pembersihan

12. **Validasi Data**

    -   Bandingkan jumlah artikel sebelum dan sesudah migrasi
    -   Periksa apakah semua gambar dapat diakses
    -   Pastikan tidak ada konten artikel yang rusak

13. **Optimasi dan Pembersihan**
    -   Hapus kode migrasi jika tidak lagi diperlukan
    -   Optimasi struktur database jika diperlukan
    -   Dokumentasikan hasil migrasi

## Implementasi Teknis

### File-file yang Akan Dibuat/Dimodifikasi

#### 1. Migration untuk Memperluas Tabel Articles

File: `database/migrations/xxxx_xx_xx_add_fields_to_articles_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('category')->nullable()->after('author');
            $table->text('tags')->nullable()->after('category');
            $table->text('excerpt')->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['category', 'tags', 'excerpt']);
        });
    }
};
```

#### 2. Konfigurasi Database WordPress

File: `config/database.php` (tambahkan ke array connections)

```php
'wordpress' => [
    'driver' => 'mysql',
    'host' => env('WORDPRESS_DB_HOST', '127.0.1'),
    'port' => env('WORDPRESS_DB_PORT', '3306'),
    'database' => env('WORDPRESS_DB_DATABASE', 'forge'),
    'username' => env('WORDPRESS_DB_USERNAME', 'forge'),
    'password' => env('WORDPRESS_DB_PASSWORD', ''),
    'unix_socket' => env('WORDPRESS_DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => env('WORDPRESS_TABLE_PREFIX', 'wp_'),
    'strict' => true,
    'engine' => null,
],
```

#### 3. Environment Variables

File: `.env`

```
WORDPRESS_DB_HOST=your_wordpress_db_host
WORDPRESS_DB_DATABASE=your_wordpress_db_name
WORDPRESS_DB_USERNAME=your_wordpress_username
WORDPRESS_DB_PASSWORD=your_wordpress_password
WORDPRESS_TABLE_PREFIX=wp_
```

#### 4. Command Migrasi

File: `app/Console/Commands/MigrateWordPressArticles.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateWordPressArticles extends Command
{
    protected $signature = 'migrate:wordpress-articles';
    protected $description = 'Migrate articles from WordPress to Laravel';

    public function handle()
    {
        $this->info('Starting WordPress to Laravel article migration...');

        // Connect to WordPress database
        $wp_connection = DB::connection('wordpress');

        // Fetch articles from WordPress
        $wp_articles = $wp_connection->select("
            SELECT
                p.ID as wp_id,
                p.post_title as title,
                p.post_content as content,
                p.post_excerpt as excerpt,
                p.post_date as created_at,
                p.post_modified as updated_at,
                u.display_name as author
            FROM wp_posts p
            LEFT JOIN wp_users u ON p.post_author = u.ID
            WHERE p.post_type = 'post'
            AND p.post_status = 'publish'
        ");

        $this->info("Found " . count($wp_articles) . " articles to migrate");

        foreach ($wp_articles as $wp_article) {
            // Process content to handle inline images
            $processed_content = $this->processArticleContent($wp_article->content, $wp_connection);

            // Get featured image
            $featured_image_path = $this->getFeaturedImage($wp_article->wp_id, $wp_connection);

            // Get categories and tags
            $categories = $this->getCategories($wp_article->wp_id, $wp_connection);
            $tags = $this->getTags($wp_article->wp_id, $wp_connection);

            // Insert into Laravel articles table
            $article = \App\Models\Article::updateOrCreate(
                ['title' => $wp_article->title],
                [
                    'title' => $wp_article->title,
                    'content' => $processed_content,
                    'excerpt' => $wp_article->excerpt,
                    'author' => $wp_article->author ?? 'Admin',
                    'category' => implode(',', $categories),
                    'tags' => implode(',', $tags),
                    'thumbnail' => $featured_image_path ?? 'default-article.jpg',
                    'created_at' => $wp_article->created_at,
                    'updated_at' => $wp_article->updated_at,
                ]
            );

            $this->info("Migrated article: {$wp_article->title}");
        }

        $this->info("All articles migrated successfully!");
    }

    private function processArticleContent($content, $wp_connection)
    {
        // Find all image tags in the content
        $pattern = '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i';

        $content = preg_replace_callback($pattern, function($matches) use ($wp_connection) {
            $original_src = $matches[1];

            // Download and save the image
            $new_image_path = $this->downloadAndSaveImage($original_src);

            if ($new_image_path) {
                // Replace the image source with the new path
                $new_img_tag = str_replace($original_src, asset('storage/' . $new_image_path), $matches[0]);
                return $new_img_tag;
            }

            return $matches[0]; // Return original if download failed
        }, $content);

        return $content;
    }

    private function getFeaturedImage($post_id, $wp_connection)
    {
        // Get the featured image ID
        $meta = $wp_connection->selectOne("
            SELECT m.meta_value as image_id
            FROM wp_postmeta m
            WHERE m.post_id = ? AND m.meta_key = '_thumbnail_id'
        ", [$post_id]);

        if ($meta) {
            // Get the image URL from the attachment post
            $image_post = $wp_connection->selectOne("
                SELECT guid, post_title
                FROM wp_posts
                WHERE ID = ?
            ", [$meta->image_id]);

            if ($image_post) {
                // Download and save the featured image
                $filename = basename($image_post->guid);
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $new_filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

                return $this->downloadAndSaveImage($image_post->guid, $new_filename, 'articles');
            }
        }

        return null;
    }

    private function downloadAndSaveImage($url, $filename = null, $directory = 'articles')
    {
        try {
            // Generate filename if not provided
            if (!$filename) {
                $filename = basename($url);
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;
            }

            // Create directory if it doesn't exist
            $full_directory = storage_path('app/public/' . $directory);
            if (!file_exists($full_directory)) {
                mkdir($full_directory, 0755, true);
            }

            // Download the image
            $image_content = file_get_contents($url);
            if ($image_content !== false) {
                $path = $full_directory . '/' . $filename;
                file_put_contents($path, $image_content);

                return $directory . '/' . $filename;
            }
        } catch (\Exception $e) {
            $this->error("Failed to download image: {$url} - " . $e->getMessage());
        }

        return null;
    }

    private function getCategories($post_id, $wp_connection)
    {
        $category_ids = $wp_connection->select("
            SELECT tr.term_taxonomy_id
            FROM wp_term_relationships tr
            JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            WHERE tr.object_id = ? AND tt.taxonomy = 'category'
        ", [$post_id]);

        $categories = [];
        foreach ($category_ids as $cat_id) {
            $term = $wp_connection->selectOne("
                SELECT name
                FROM wp_terms
                WHERE term_id = ?
            ", [$cat_id->term_taxonomy_id]);

            if ($term) {
                $categories[] = $term->name;
            }
        }

        return $categories;
    }

    private function getTags($post_id, $wp_connection)
    {
        $tag_ids = $wp_connection->select("
            SELECT tr.term_taxonomy_id
            FROM wp_term_relationships tr
            JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            WHERE tr.object_id = ? AND tt.taxonomy = 'post_tag'
        ", [$post_id]);

        $tags = [];
        foreach ($tag_ids as $tag_id) {
            $term = $wp_connection->selectOne("
                SELECT name
                FROM wp_terms
                WHERE term_id = ?
            ", [$tag_id->term_taxonomy_id]);

            if ($term) {
                $tags[] = $term->name;
            }
        }

        return $tags;
    }
}
```

## Pengujian dan Validasi

### Unit Testing

-   Buat unit test untuk command migrasi
-   Uji fungsi-fungsi penting secara terpisah
-   Validasi bahwa gambar berhasil diunduh dan disimpan

### End-to-End Testing

-   Migrasi dataset kecil terlebih dahulu
-   Verifikasi tampilan artikel di frontend
-   Pastikan semua gambar dapat diakses

## Jadwal Pelaksanaan

| Fase   | Durasi   | Deskripsi                   |
| ------ | -------- | --------------------------- |
| Fase 1 | 1 hari   | Persiapan dan analisis      |
| Fase 2 | 0.5 hari | Perubahan struktur database |
| Fase 3 | 1 hari   | Pembuatan alat migrasi      |
| Fase 4 | 1 hari   | Penanganan gambar           |
| Fase 5 | 1-2 hari | Eksekusi migrasi            |
| Fase 6 | 0.5 hari | Validasi dan pembersihan    |

## Risiko dan Mitigasi

### Risiko

1. **Kehilangan data gambar** - Beberapa URL gambar mungkin tidak valid
2. **Perbedaan struktur data** - Struktur WordPress dan Laravel berbeda
3. **Ukuran file besar** - Migrasi bisa memakan waktu lama
4. **Koneksi database** - Masalah koneksi ke database WordPress

### Mitigasi

1. **Backup sebelum migrasi** - Selalu backup data sebelum migrasi
2. **Validasi ekstensif** - Lakukan validasi sebelum dan sesudah migrasi
3. **Batch processing** - Proses data dalam batch untuk menghindari timeout
4. **Logging komprehensif** - Catat semua proses migrasi untuk debugging

## Checklist Persiapan

-   [ ] Backup database WordPress
-   [ ] Backup direktori upload WordPress
-   [ ] Konfigurasi koneksi database WordPress di Laravel
-   [ ] Pastikan storage Laravel siap digunakan (`php artisan storage:link`)
-   [ ] Test koneksi database WordPress dari Laravel
-   [ ] Siapkan environment development untuk uji coba
