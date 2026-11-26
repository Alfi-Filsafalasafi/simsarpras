<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = ['nama', 'kode'];

    public function sarana(): HasMany
    {
        return $this->hasMany(Sarana::class);
    }
}