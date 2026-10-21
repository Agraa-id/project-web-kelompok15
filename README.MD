# MotoCare — Week 6 PHP OOP

Dashboard MotoCare mencakup dashboard kondisi kendaraan dan Program Prioritas. Halaman Program Prioritas (`index.php`) menggunakan PHP berorientasi objek dan server-side rendering.

## Implementasi Program Prioritas

- Class `MotoCareProgram` merepresentasikan data satu program perawatan.
- Setiap object menyimpan properties kode, judul, deskripsi, kategori, prioritas, status, progres, target, dan tim.
- Method getter menyediakan data program untuk ringkasan dan halaman.
- Method object menentukan kelas badge status dan prioritas.
- Loop PHP menghasilkan kartu dinamis dan nomor urut dari daftar object.
- HTML di-escape sebelum dirender.
- Tampilan responsif menggunakan CSS terpisah.

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
   - `http://localhost:8000/index.php`

PHP harus dijalankan melalui server, bukan dengan membuka file menggunakan `file://`. Google Fonts dan data REST API NHTSA memerlukan koneksi internet.

Untuk membangun ulang CSS secara otomatis ketika file terkait diubah, jalankan `npm run watch:css` di terminal terpisah.
