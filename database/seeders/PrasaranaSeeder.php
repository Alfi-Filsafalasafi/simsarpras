<?php

namespace Database\Seeders;

use App\Models\Prasarana;
use Illuminate\Database\Seeder;

class PrasaranaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['R-001', 'Ruang Kelas X-1', 'Ruang Kelas', 63, 32, 2015, 'baik', 'Wali Kelas X-1'],
            ['R-002', 'Ruang Kelas X-2', 'Ruang Kelas', 63, 32, 2015, 'baik', 'Wali Kelas X-2'],
            ['R-003', 'Ruang Kelas XI-1', 'Ruang Kelas', 63, 32, 2015, 'rusak_ringan', 'Wali Kelas XI-1'],
            ['R-010', 'Laboratorium Komputer', 'Laboratorium', 80, 36, 2018, 'baik', 'Kepala Laboratorium'],
            ['R-011', 'Perpustakaan', 'Perpustakaan', 96, 40, 2012, 'baik', 'Pustakawan'],
            ['R-020', 'Ruang Guru', 'Ruang Guru', 72, 25, 2012, 'baik', 'Waka Kurikulum'],
            ['R-030', 'Lapangan Upacara', 'Lapangan', 600, null, 2010, 'rusak_ringan', 'Guru Olahraga'],
            ['R-040', 'Gudang Sarpras', 'Gudang', 24, null, 2010, 'rusak_berat', 'Petugas Sarpras'],
        ];

        foreach ($data as [$kode, $nama, $jenis, $luas, $kapasitas, $tahun, $kondisi, $pj]) {
            Prasarana::updateOrCreate(
                ['kode_ruang' => $kode],
                [
                    'nama_ruang' => $nama,
                    'jenis' => $jenis,
                    'luas' => $luas,
                    'kapasitas' => $kapasitas,
                    'tahun_bangun' => $tahun,
                    'kondisi' => $kondisi,
                    'penanggung_jawab' => $pj,
                ]
            );
        }
    }
}