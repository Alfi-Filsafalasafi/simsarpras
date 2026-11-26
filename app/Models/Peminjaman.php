<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    public const STATUS = [
        'dipinjam' => 'Dipinjam',
        'dikembalikan' => 'Dikembalikan',
        'terlambat' => 'Terlambat',
    ];

    protected $fillable = [
        'user_id',
        'sarana_id',
        'prasarana_id',
        'peminjam',
        'keperluan',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali',
        'status',
        'kondisi_kembali',
        'catatan',
        'dicatat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'datetime',
            'tanggal_rencana_kembali' => 'datetime',
            'tanggal_kembali' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class);
    }

    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(Prasarana::class);
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}