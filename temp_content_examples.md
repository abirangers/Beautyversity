# Contoh 1: Migrasi Artikel WordPress ke Laravel

Migrasi konten WordPress ke Laravel dilakukan dengan menjalankan perintah `php artisan migrate:all-wordpress-content`. Pastikan koneksi database WordPress dikonfigurasi di `.env` menggunakan driver `mysql`, host, port, database, username, dan password yang sesuai.

Langkah penting:
- Pastikan struktur tabel `wp_posts` lengkap.
- Jalankan perintah dengan opsi `--type=posts` bila hanya ingin memigrasi artikel dan draft.
- Verifikasi hasil di tabel `articles` dan `article_categories` setelah proses selesai.

# Contoh 2: Pengaturan Koneksi Database WordPress

Tambahkan konfigurasi berikut pada file `.env`:

```env
WORDPRESS_DB_CONNECTION=mysql
WORDPRESS_DB_HOST=127.0.0.1
WORDPRESS_DB_PORT=3306
WORDPRESS_DB_DATABASE=wordpress_db
WORDPRESS_DB_USERNAME=wordpress_user
WORDPRESS_DB_PASSWORD=secret
```

Lalu pastikan koneksi diregistrasikan di `config/database.php` menggunakan array koneksi bernama `wordpress`.

# Contoh 3: Memastikan Storage Link Aktif

Sebelum menampilkan lampiran yang dimigrasi, jalankan:

```bash
php artisan storage:link
```

Perintah ini membuat symbolic link ke `public/storage`. Tanpa ini, gambar unggahan hasil migrasi tidak akan tampil di front-end.

# Contoh 4: Validasi Data Setelah Migrasi

Gunakan Tinker atau query langsung untuk memeriksa kelengkapan data:

```bash
php artisan tinker
>>> App\\Models\\Article::latest()->take(5)->get(['title','status','slug']);
```

Pastikan status artikel (`publish` atau `draft`), slug unik, serta relasi kategori dan tag tersinkronisasi.

# Contoh 5: Migrasi Ulang Lampiran Saja

Jika hanya lampiran yang ingin diulang, jalankan perintah berikut:

```bash
php artisan migrate:all-wordpress-content --type=attachments
```

Perintah ini mengunduh ulang lampiran dari URL asli WordPress dan menyimpannya ke `storage/app/public/attachments`.
