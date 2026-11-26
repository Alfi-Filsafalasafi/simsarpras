<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sarana extends Model
{
    protected $table = 'sarana';

    public const KONDISI = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak Ringan',
        'rusak_berat' => 'Rusak Berat',
    ];

    public const SUMBER_DANA = ['BOS', 'Komite', 'Hibah', 'Lainnya'];

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_DIHAPUS = 'dihapus';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'prasarana_id',
        'merek',
        'nomor_seri',
        'jumlah',
        'tahun_perolehan',
        'sumber_dana',
        'harga',
        'kondisi',
        'status',
        'foto',
        'keterangan',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class);
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function laporanKerusakan(): HasMany
    {
        return $this->hasMany(LaporanKerusakan::class);
    }

    public function jadwalPemeliharaan(): HasMany
    {
        return $this->hasMany(JadwalPemeliharaan::class);
    }

    public function mutasi(): HasMany
    {
        return $this->hasMany(MutasiAset::class);
    }
}