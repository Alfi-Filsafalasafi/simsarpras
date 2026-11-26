<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenghapusanAset extends Model
{
    protected $table = 'penghapusan_aset';

    public const ALASAN = [
        'rusak_berat' => 'Rusak Berat',
        'hilang' => 'Hilang',
        'usang' => 'Usang/Tidak Layak Pakai',
    ];

    public const STATUS = [
        'diajukan' => 'Diajukan',
        'disetujui' => 'Disetujui',
        'ditolak' => 'Ditolak',
    ];

    protected $fillable = [
        'sarana_id',
        'alasan',
        'keterangan',
        'tanggal',
        'bukti',
        'status',
        'nomor_berita_acara',
        'diajukan_oleh',
        'disetujui_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class);
    }

    public function pengaju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diajukan_oleh');
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}