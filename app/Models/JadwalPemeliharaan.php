<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPemeliharaan extends Model
{
    protected $table = 'jadwal_pemeliharaan';

    protected $fillable = [
        'sarana_id',
        'prasarana_id',
        'kegiatan',
        'interval_bulan',
        'tanggal_terakhir',
        'tanggal_berikutnya',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_terakhir' => 'date',
            'tanggal_berikutnya' => 'date',
        ];
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