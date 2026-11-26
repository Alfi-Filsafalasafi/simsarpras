<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prasarana extends Model
{
    protected $table = 'prasarana';

    public const JENIS = [
        'Ruang Kelas',
        'Laboratorium',
        'Perpustakaan',
        'Ruang Guru',
        'Ruang Kepala Sekolah',
        'Toilet',
        'Lapangan',
        'Gudang',
        'Musala',
        'Kantin',
        'Lainnya',
    ];

    public const KONDISI = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak Ringan',
        'rusak_berat' => 'Rusak Berat',
    ];

    public const KONDISI_WARNA = [
        'baik' => 'success',
        'rusak_ringan' => 'warning',
        'rusak_berat' => 'danger',
    ];

    protected $fillable = [
        'kode_ruang',
        'nama_ruang',
        'jenis',
        'luas',
        'kapasitas',
        'tahun_bangun',
        'kondisi',
        'penanggung_jawab',
        'foto',
        'keterangan',
    ];

    public function sarana(): HasMany
    {
        return $this->hasMany(Sarana::class);
    }

    public function getKondisiLabelAttribute(): string
    {
        return self::KONDISI[$this->kondisi] ?? (string) $this->kondisi;
    }

    public function getKondisiWarnaAttribute(): string
    {
        return self::KONDISI_WARNA[$this->kondisi] ?? 'secondary';
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/'.$this->foto) : null;
    }

    public function getLuasFormatAttribute(): string
    {
        if ($this->luas === null) {
            return '-';
        }

        return rtrim(rtrim(number_format((float) $this->luas, 2, ',', '.'), '0'), ',').' m²';
    }

    public static function kodeBerikutnya(): string
    {
        $terakhir = static::where('kode_ruang', 'like', 'R-%')
            ->orderByRaw('CAST(SUBSTRING(kode_ruang, 3) AS UNSIGNED) DESC')
            ->value('kode_ruang');

        $angka = $terakhir ? ((int) substr($terakhir, 2)) + 1 : 1;

        return 'R-'.str_pad((string) $angka, 3, '0', STR_PAD_LEFT);
    }
}