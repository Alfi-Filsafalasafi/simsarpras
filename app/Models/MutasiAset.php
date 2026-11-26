<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiAset extends Model
{
    protected $table = 'mutasi_aset';

    protected $fillable = [
        'sarana_id',
        'lokasi_asal_id',
        'lokasi_tujuan_id',
        'tanggal',
        'alasan',
        'user_id',
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

    public function lokasiAsal(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class, 'lokasi_asal_id');
    }

    public function lokasiTujuan(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class, 'lokasi_tujuan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}