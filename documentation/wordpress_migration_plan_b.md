# Plan B: WordPress Export/Import Method

## Pendahuluan
Plan B ini menyediakan pendekatan alternatif untuk migrasi artikel dari WordPress ke Laravel menggunakan metode export/import XML. Ini adalah metode standar WordPress yang tidak memerlukan akses langsung ke database.

## Tujuan
- Menyediakan metode migrasi alternatif tanpa akses database
- Menggunakan fitur bawaan WordPress untuk export/import
- Menjaga integritas data artikel dan struktur informasi

## Lingkup
- Migrasi data artikel (judul, konten, penulis, tanggal pembuatan, dll.)
- Migrasi gambar artikel (gambar fitur dan gambar inline dalam konten)
- Migrasi metadata artikel (kategori, tag)
- Tanpa perlu akses ke database WordPress

## Prasyarat
- Akses ke admin panel WordPress
- Fitur export WordPress aktif
- Koneksi internet yang stabil untuk download/upload file
- Pengetahuan tentang struktur file XML WordPress

## Proses Migrasi

### Fase 1: Ekspor Data dari WordPress
1. **Login ke Admin WordPress**
   - Akses admin panel WordPress
   - Navigasi ke Tools → Export

2. **Pilih Konten untuk Diekspor**
   - Pilih "Posts" atau "All content" tergantung kebutuhan
   - Pilih kategori jika hanya ingin mengekspor sebagian artikel
   - Klik "Download Export File"

3. **Simpan File XML**
   - Simpan file XML hasil ekspor ke direktori lokal
   - File biasanya bernama seperti `wordpress-export.xml`

### Fase 2: Pembuatan Alat Migrasi
4. **Buat Command Artisan untuk Migrasi XML**
   - Buat command: `php artisan make:command MigrateWordPressXml`
   - Implementasikan logika parsing XML dan migrasi data

5. **Implementasi Fungsi-Fungsi Migrasi**
   - Fungsi untuk parsing file XML WordPress
   - Fungsi untuk mengunduh dan menyimpan gambar
   - Fungsi untuk memproses konten artikel
   - Fungsi untuk menyimpan artikel ke database Laravel

### Fase 3: Penanganan Gambar
6. **Implementasi Download dan Penyimpanan Gambar dari XML**
   - Download gambar dari URL yang ditemukan dalam XML
   - Proses gambar inline dalam konten artikel
   - Update URL gambar dalam konten artikel

7. **Validasi dan Backup Gambar**
   - Validasi bahwa semua gambar berhasil diunduh
   - Pastikan ukuran dan format gambar valid

### Fase 4: Eksekusi Migrasi
8. **Uji Coba di Lingkungan Development**
   - Jalankan migrasi pada beberapa artikel pertama
   - Verifikasi bahwa data dan gambar berhasil dipindahkan
   - Perbaiki masalah yang ditemukan

9. **Migrasi Produksi**
   - Jalankan migrasi secara penuh
   - Monitor proses untuk mendeteksi potensi masalah
   - Verifikasi hasil migrasi

### Fase 5: Validasi dan Pembersihan
10. **Validasi Data**
    - Bandingkan jumlah artikel sebelum dan sesudah migrasi
    - Periksa apakah semua gambar dapat diakses
    - Pastikan tidak ada konten artikel yang rusak

11. **Optimasi dan Pembersihan**
    - Hapus kode migrasi jika tidak lagi diperlukan
    - Optimasi struktur database jika diperlukan
    - Dokumentasikan hasil migrasi

## Implementasi Teknis

### File-file yang Akan Dibuat

#### 1. Command Migrasi XML
File: `app/Console/Commands/MigrateWordPressXml.php`
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;

class MigrateWordPressXml extends Command
{
    protected $signature = 'migrate:wordpress-xml {file}';
    protected $description = 'Migrate articles from WordPress using XML export file';

    public function handle()
    {
        $xmlFile = $this->argument('file');
        if (!file_exists($xmlFile)) {
            $this->error("XML file does not exist: {$xmlFile}");
            return;
        }
        
        $this->info('Starting WordPress to Laravel article migration via XML...');
        
        // Parse XML file
        $xml = simplexml_load_file($xmlFile);
        
        // Register WordPress namespace
        $xml->registerXPathNamespace('wp', 'http://wordpress.org/export/1.2/');
        
        // Process each post
        foreach ($xml->channel->item as $item) {
            // Check if it's a post
            $post_type = $item->children('wp', true)->post_type;
            if ($post_type == 'post') {
                // Extract post data
                $title = (string)$item->title;
                $content = (string)$item->children('content', true)->encoded;
                $excerpt = (string)$item->children('excerpt', true)->encoded;
                $author = (string)$item->children('dc', true)->creator;
                $date = (string)$item->pubDate;
                $modified = (string)$item->children('wp', true)->post_modified;
                
                // Extract categories and tags
                $categories = [];
                $tags = [];
                foreach ($item->category as $category) {
                    $domain = (string)$category->attributes()->domain;
                    $name = (string)$category;
                    
                    if ($domain === 'category') {
                        $categories[] = $name;
                    } elseif ($domain === 'post_tag') {
                        $tags[] = $name;
                    }
                }
                
                // Process content to handle images
                $processed_content = $this->processContentImages($content);
                
                // Process featured image if exists in XML
                $featured_image_path = $this->extractFeaturedImage($item);
                
                // Create or update article in Laravel
                $article = \App\Models\Article::updateOrCreate(
                    ['title' => $title],
                    [
                        'title' => $title,
                        'content' => $processed_content,
                        'excerpt' => $excerpt,
                        'author' => $author,
                        'category' => implode(',', $categories),
                        'tags' => implode(',', $tags),
                        'thumbnail' => $featured_image_path ?? 'default-article.jpg',
                        'created_at' => $date,
                        'updated_at' => $modified,
                    ]
                );
                
                $this->info("Migrated article: {$title}");
            }
        }
        
        $this->info("All articles migrated successfully via XML!");
    }
    
    private function processContentImages($content)
    {
        // Find all image tags in the content
        $pattern = '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i';
        
        $content = preg_replace_callback($pattern, function($matches) {
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
    
    private function extractFeaturedImage($item)
    {
        // Look for featured image in XML
        $wp_children = $item->children('wp', true);
        foreach ($wp_children->attachment_url as $attachment) {
            $url = (string)$attachment;
            // Check if this is likely a featured image by looking at the context
            // This might require additional logic based on your XML structure
            if (strpos($url, '/wp-content/uploads/') !== false) {
                return $this->downloadAndSaveImage($url, null, 'articles');
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
}
```

## Perintah untuk Eksekusi

```bash
# Migrasi dengan file XML
php artisan migrate:wordpress-xml /path/to/wordpress-export.xml
```

## Kelebihan Plan B

1. **Tidak Perlu Akses Database**
   - Menggunakan fitur export bawaan WordPress
   - Lebih aman dari segi keamanan
   - Tidak perlu konfigurasi koneksi database tambahan

2. **Metode Standar WordPress**
   - Menggunakan format export resmi WordPress
   - Mempertahankan struktur dan metadata artikel

3. **Kompatibel dengan Hosting Lain**
   - Bekerja dengan WordPress yang dihosting di platform lain
   - Tidak tergantung pada struktur database internal

## Kekurangan Plan B

1. **File XML Bisa Sangat Besar**
   - Untuk situs dengan banyak artikel
   - Bisa menyebabkan masalah memori saat parsing

2. **Tidak Semua Data Terexport**
   - Plugin khusus mungkin tidak terexport dengan baik
   - Metadata kustom mungkin hilang

3. **Parsing yang Kompleks**
   - Struktur XML WordPress cukup kompleks
   - Mungkin perlu logika tambahan untuk mengenali featured image

## Kapan Menggunakan Plan B

- Akses database WordPress tidak tersedia atau dibatasi
- Lingkungan produksi yang sangat dibatasi keamanannya
- WordPress dihosting di platform yang tidak memungkinkan akses database
- Ketika pendekatan utama mengalami masalah teknis

## Validasi dan Pengujian

### Unit Testing
- Buat unit test untuk command migrasi XML
- Mock file XML untuk pengujian tanpa file asli
- Uji fungsi-fungsi penting secara terpisah

### End-to-End Testing
- Migrasi beberapa artikel pertama sebagai uji coba
- Verifikasi tampilan artikel di frontend
- Pastikan semua gambar dapat diakses