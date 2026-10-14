# MotoCare — Week 5 PHP Prosedural

Dashboard Program Prioritas MotoCare dibuat dengan PHP prosedural dan server-side rendering.

## Implementasi
- Variabel PHP untuk judul halaman, workspace, pemilik, dan periode.
- Array multidimensi untuk data program prioritas.
- Ringkasan jumlah program dihitung dari data PHP.
- Loop PHP menghasilkan kartu dinamis dan nomor urut.
- Status dan prioritas menentukan kelas badge secara kondisional.
- HTML di-escape sebelum dirender.
- Tampilan responsif menggunakan CSS terpisah.

## Menjalankan

Pastikan PHP tersedia, lalu jalankan dari folder project:

```powershell
php -S localhost:8000
```

Buka `http://localhost:8000` di browser. Jangan membuka halaman dengan `file://`, karena PHP harus diproses oleh server.