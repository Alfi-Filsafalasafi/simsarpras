<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeliharaan;
use App\Models\Kategori;
use App\Models\LaporanKerusakan;
use App\Models\Peminjaman;
use App\Models\Prasarana;
use App\Models\Sarana;
use App\Models\User;
use App\Models\UsulanPengadaan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $isGuru = $user->hasRole(User::ROLE_GURU);

        // Kartu ringkasan aset
        $totalPrasarana = Prasarana::count();
        $totalSarana = (int) Sarana::where('status', Sarana::STATUS_AKTIF)->sum('jumlah');

        $kondisi = Sarana::where('status', Sarana::STATUS_AKTIF)
            ->selectRaw('kondisi, SUM(jumlah) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        $baik = (int) ($kondisi['baik'] ?? 0);
        $rusakRingan = (int) ($kondisi['rusak_ringan'] ?? 0);
        $rusakBerat = (int) ($kondisi['rusak_berat'] ?? 0);

        // Kartu operasional
        $peminjamanBerjalan = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])
            ->when($isGuru, fn ($q) => $q->where('user_id', $user->id))
            ->count();

        $kerusakanAktif = LaporanKerusakan::whereIn('status', ['dilaporkan', 'diproses'])
            ->when($isGuru, fn ($q) => $q->where('user_id', $user->id))
            ->count();

        $pemeliharaanTerdekat = JadwalPemeliharaan::whereBetween('tanggal_berikutnya', [today(), today()->addDays(30)])
            ->count();

        // Usulan menunggu, menyesuaikan peran
        $usulanQuery = UsulanPengadaan::with('pengusul');

        if ($isGuru) {
            $judulUsulan = 'Usulan Saya yang Sedang Diproses';
            $usulanQuery->where('user_id', $user->id)->whereIn('status', ['diajukan', 'diverifikasi']);
        } elseif ($user->hasRole(User::ROLE_KEPSEK)) {
            $judulUsulan = 'Usulan Menunggu Persetujuan';
            $usulanQuery->where('status', 'diverifikasi');
        } else {
            $judulUsulan = 'Usulan Menunggu Verifikasi';
            $usulanQuery->where('status', 'diajukan');
        }

        $jumlahUsulan = (clone $usulanQuery)->count();
        $usulanMenunggu = $usulanQuery->latest()->take(5)->get();

        // Daftar tugas lainnya
        $jatuhTempo = Peminjaman::with(['sarana', 'prasarana'])
            ->where('status', 'dipinjam')
            ->where('tanggal_rencana_kembali', '<=', now()->addDays(2))
            ->when($isGuru, fn ($q) => $q->where('user_id', $user->id))
            ->orderBy('tanggal_rencana_kembali')
            ->take(5)
            ->get();

        $perbaikan = LaporanKerusakan::with(['sarana', 'prasarana'])
            ->whereIn('status', ['dilaporkan', 'diproses'])
            ->when($isGuru, fn ($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(5)
            ->get();

        // Data grafik: aset per kategori
        $perKategori = Kategori::withSum(
            ['sarana as total_unit' => fn ($q) => $q->where('status', Sarana::STATUS_AKTIF)],
            'jumlah'
        )->orderBy('nama')->get();

        $labelKategori = $perKategori->pluck('nama');
        $dataKategori = $perKategori->map(fn ($k) => (int) $k->total_unit);

        // Data grafik: tren 6 bulan terakhir
        $bulan = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));

        $labelTren = $bulan->map(fn ($b) => $b->translatedFormat('M Y'));

        $trenPeminjaman = $bulan->map(fn ($b) => Peminjaman::whereBetween('tanggal_pinjam', [
            $b->copy()->startOfMonth(),
            $b->copy()->endOfMonth(),
        ])->count());

        $trenKerusakan = $bulan->map(fn ($b) => LaporanKerusakan::whereBetween('created_at', [
            $b->copy()->startOfMonth(),
            $b->copy()->endOfMonth(),
        ])->count());

        $kartuAset = [
            ['label' => 'Total Prasarana', 'nilai' => $totalPrasarana, 'icon' => 'bi-building', 'warna' => 'primary'],
            ['label' => 'Total Sarana (unit)', 'nilai' => $totalSarana, 'icon' => 'bi-box-seam', 'warna' => 'info'],
            ['label' => 'Kondisi Baik', 'nilai' => $baik, 'icon' => 'bi-check-circle', 'warna' => 'success'],
            ['label' => 'Rusak Ringan', 'nilai' => $rusakRingan, 'icon' => 'bi-exclamation-triangle', 'warna' => 'warning'],
            ['label' => 'Rusak Berat', 'nilai' => $rusakBerat, 'icon' => 'bi-x-circle', 'warna' => 'danger'],
        ];

        $kartuOperasional = [
            ['label' => 'Peminjaman Berjalan', 'nilai' => $peminjamanBerjalan, 'icon' => 'bi-arrow-left-right', 'warna' => 'primary'],
            ['label' => $judulUsulan, 'nilai' => $jumlahUsulan, 'icon' => 'bi-hourglass-split', 'warna' => 'warning'],
            ['label' => 'Laporan Kerusakan Aktif', 'nilai' => $kerusakanAktif, 'icon' => 'bi-tools', 'warna' => 'danger'],
            ['label' => 'Pemeliharaan 30 Hari', 'nilai' => $pemeliharaanTerdekat, 'icon' => 'bi-calendar-check', 'warna' => 'info'],
        ];

        return view('dashboard', compact(
            'kartuAset',
            'kartuOperasional',
            'totalSarana',
            'baik',
            'rusakRingan',
            'rusakBerat',
            'judulUsulan',
            'usulanMenunggu',
            'jatuhTempo',
            'perbaikan',
            'labelKategori',
            'dataKategori',
            'labelTren',
            'trenPeminjaman',
            'trenKerusakan'
        ));
    }
}