# MotoCare — Week 7 PHP MVC

Dashboard MotoCare mencakup dashboard kondisi kendaraan dan Program Prioritas. Halaman Program Prioritas menggunakan PHP berorientasi objek, server-side rendering, pola Model-View-Controller (MVC), serta MySQL untuk menyimpan data program.

## Struktur MVC Program Prioritas

- `Database/migrations/001_create_programs_table.sql` membuat tabel `programs` dengan kolom `id`, `nama`, `deskripsi`, `created_at`, dan `updated_at`.
- `Database/Database.php` membuat koneksi PDO ke MySQL.
- `Model/MotoCareProgram.php` merepresentasikan satu program MotoCare.
- `Model/ProgramModel.php` membaca dan menjalankan operasi CRUD pada tabel `programs` menggunakan prepared statements.
- `Controller/ProgramController.php` memvalidasi aksi, memproses form, dan meneruskan data database ke View.
- `View/program-prioritas.php` menampilkan form tambah, daftar program, dan form edit/hapus.
- `index.php` menjadi halaman utama MotoCare.
- `program-prioritas-mvc.php` meneruskan request Program Prioritas ke Controller.
- `Database/migrate.php` menyiapkan database dan menjalankan migration.
- Data teks di View di-escape sebelum dirender; tampilan responsif memakai CSS terpisah.

Alur request Program Prioritas MVC: browser → `program-prioritas-mvc.php` → `ProgramController` → `ProgramModel` → MySQL.

## Database Program MotoCare

Pastikan MySQL aktif dan PHP memiliki ekstensi `pdo_mysql`. Secara default aplikasi memakai host `127.0.0.1`, port `3306`, database `motocare`, user `root`, dan password kosong. Atur environment variable berikut sebelum menjalankan migration/server jika konfigurasi lokal berbeda:

```powershell
$env:DB_HOST = "127.0.0.1"
$env:DB_PORT = "3306"
$env:DB_NAME = "motocare"
$env:DB_USER = "root"
$env:DB_PASSWORD = ""
```

Jalankan migration sekali dari root project. Perintah ini membuat database bila belum ada (akun MySQL harus memiliki izin membuat database) dan menyiapkan tabel `programs`:

```powershell
php Database/migrate.php
```

Halaman `program-prioritas-mvc.php` menyediakan Create, Read, Update, dan Delete. Daftar program dibaca dari MySQL, sehingga tidak ada daftar program contoh yang ditanam di kode aplikasi.

## Fitur Tampilan

- Dashboard kondisi kendaraan.
- Riwayat perawatan dan biaya servis.
- Pengingat servis berdasarkan tanggal dan estimasi kilometer.
- Daftar merek motor dari REST API NHTSA dengan status loading, error, dan coba lagi.
- Daftar perawatan interaktif memakai REST API PHP (`GET`, `POST`, dan `PATCH`) dengan loading, refresh, validasi, serta penanganan error.
- Tampilan responsif untuk desktop dan mobile.
- Struktur HTML semantik dengan utility Tailwind CSS.

## Menjalankan Project

Pastikan PHP dan Node.js sudah terpasang.

1. Jalankan `npm install` untuk memasang dependensi Tailwind CSS.
2. Jalankan `npm run build:css` untuk menghasilkan CSS dari konfigurasi input project.
3. Siapkan koneksi MySQL dan jalankan `php Database/migrate.php`.
4. Jalankan server PHP dari folder project:

   ```powershell
   php -S localhost:8000
   ```

5. Buka halaman berikut di browser:
   - `http://localhost:8000/index.php`
   - `http://localhost:8000/program-prioritas.php`
   - `http://localhost:8000/program-prioritas-mvc.php` (Program Prioritas berbasis MVC)

PHP harus dijalankan melalui server, bukan dengan membuka file menggunakan `file://`. Google Fonts dan data REST API NHTSA memerlukan koneksi internet.

Daftar perawatan pada `program-prioritas.php` memakai endpoint `api/program-perawatan.php`. Data disimpan per sesi PHP; perubahan tetap tersedia selama sesi browser aktif dan akan diinisialisasi ulang ketika sesi berakhir.

Untuk membangun ulang CSS secara otomatis ketika file terkait diubah, jalankan `npm run watch:css` di terminal terpisah.
