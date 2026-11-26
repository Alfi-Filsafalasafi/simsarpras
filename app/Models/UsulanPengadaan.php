<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulanPengadaan extends Model
{
    protected $table = 'usulan_pengadaan';

    public const STATUS = [
        'diajukan' => 'Diajukan',
        'diverifikasi' => 'Diverifikasi',
        'disetujui' => 'Disetujui',
        'ditolak' => 'Ditolak',
        'terealisasi' => 'Terealisasi',
    ];

    protected $fillable = [
        'user_id',
        'unit_kerja',
        'nama_barang',
        'jumlah',
        'estimasi_harga',
        'alasan',
        'lampiran',
        'status',
        'catatan_verifikasi',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
        'catatan_persetujuan',
        'disetujui_oleh',
        'tanggal_persetujuan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_verifikasi' => 'datetime',
            'tanggal_persetujuan' => 'datetime',
        ];
    }

    public function pengusul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}