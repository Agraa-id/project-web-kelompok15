# MotoCare — Week 7 PHP MVC

Dashboard MotoCare mencakup dashboard kondisi kendaraan dan Program Prioritas. Halaman Program Prioritas menggunakan PHP berorientasi objek, server-side rendering, dan pola Model-View-Controller (MVC).

## Struktur MVC Program Prioritas

- `Model/MotoCareProgram.php` mendefinisikan object satu program perawatan beserta getter dan class badge.
- `Model/ProgramModel.php` menyediakan daftar program MotoCare.
- `Controller/ProgramController.php` menerima request halaman, mengambil data dari Model, menghitung ringkasan, lalu memuat View.
- `View/program-prioritas.php` merender ringkasan dan kartu program dari data Controller.
- `index.php` menjadi entry point yang meneruskan request ke Controller.
- Data teks di View di-escape sebelum dirender; tampilan responsif memakai CSS terpisah.

Alur request: browser → `index.php` → `ProgramController` → `ProgramModel` → View.

## Fitur Tampilan

- Dashboard kondisi kendaraan.
- Riwayat perawatan dan biaya servis.
- Pengingat servis berdasarkan tanggal dan estimasi kilometer.
- Daftar merek motor dari REST API NHTSA dengan status loading, error, dan coba lagi.
- Tampilan responsif untuk desktop dan mobile.
- Struktur HTML semantik dengan utility Tailwind CSS.

## Menjalankan Project

Pastikan PHP dan Node.js sudah terpasang.

1. Jalankan `npm install` untuk memasang dependensi Tailwind CSS.
2. Jalankan `npm run build:css` untuk menghasilkan CSS dari konfigurasi input project.
3. Jalankan server PHP dari folder project:

   ```powershell
   php -S localhost:8000
   ```

4. Buka halaman berikut di browser:
   - `http://localhost:8000/index.html`
   - `http://localhost:8000/program-prioritas.php`
   - `http://localhost:8000/index.php` (dashboard Program Prioritas berbasis MVC)

PHP harus dijalankan melalui server, bukan dengan membuka file menggunakan `file://`. Google Fonts dan data REST API NHTSA memerlukan koneksi internet.

Untuk membangun ulang CSS secara otomatis ketika file terkait diubah, jalankan `npm run watch:css` di terminal terpisah.
