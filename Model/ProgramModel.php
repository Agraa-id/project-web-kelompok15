<?php
require_once __DIR__ . '/MotoCareProgram.php';

final class ProgramModel
{
    /**
     * @return MotoCareProgram[]
     */
    public function getAll(): array
    {
        return [
            new MotoCareProgram(
                'MTR-01',
                'Pencatatan riwayat servis',
                'Mencatat tanggal, jenis perawatan, bengkel, dan biaya servis motor.',
                'Riwayat perawatan',
                'Tinggi',
                'Berjalan',
                75,
                '20 Okt 2026',
                'Tim MotoCare'
            ),
            new MotoCareProgram(
                'MTR-02',
                'Pengingat servis berkala',
                'Mengingatkan pemilik motor berdasarkan jadwal servis dan estimasi kilometer.',
                'Jadwal servis',
                'Tinggi',
                'Berjalan',
                58,
                '24 Okt 2026',
                'Tim MotoCare'
            ),
            new MotoCareProgram(
                'MTR-03',
                'Ringkasan kondisi motor',
                'Menampilkan kondisi motor, odometer, serta informasi perawatan dalam dashboard.',
                'Dashboard',
                'Sedang',
                'Perencanaan',
                20,
                '30 Okt 2026',
                'Tim MotoCare'
            ),
            new MotoCareProgram(
                'MTR-04',
                'Referensi merek motor',
                'Mengambil daftar merek motor dari layanan API sebagai referensi kendaraan.',
                'Integrasi',
                'Rendah',
                'Selesai',
                100,
                '10 Okt 2026',
                'Tim MotoCare'
            ),
        ];
    }
}
