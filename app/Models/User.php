<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_KEPSEK = 'kepala_sekolah';
    public const ROLE_WAKA = 'waka_sarpras';
    public const ROLE_PETUGAS = 'petugas_sarpras';
    public const ROLE_GURU = 'guru';

    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_KEPSEK => 'Kepala Sekolah',
        self::ROLE_WAKA => 'Wakil Kepala Sekolah Bidang Sarpras',
        self::ROLE_PETUGAS => 'Petugas Sarpras',
        self::ROLE_GURU => 'Guru/Staf',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function getNamaRoleAttribute(): string
    {
        return self::ROLES[$this->role] ?? $this->role;
    }
}