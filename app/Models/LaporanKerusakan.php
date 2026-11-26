<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKerusakan extends Model
{
    protected $table = 'laporan_kerusakan';

    public const STATUS = [
        'dilaporkan' => 'Dilaporkan',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
    ];

    public const URGENSI = [
        'rendah' => 'Rendah',
        'sedang' => 'Sedang',
        'tinggi' => 'Tinggi',
    ];

    protected $fillable = [
        'user_id',
        'sarana_id',
        'prasarana_id',
        'deskripsi',
        'urgensi',
        'foto',
        'status',
        'teknisi',
        'tindak_lanjut',
        'biaya',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_selesai' => 'date',
        ];
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class);
    }

    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class);
    }
}