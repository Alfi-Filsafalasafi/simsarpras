<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Admin SIMSARPRAS', 'admin@simsarpras.test', User::ROLE_ADMIN],
            ['Kepala Sekolah', 'kepsek@simsarpras.test', User::ROLE_KEPSEK],
            ['Waka Sarpras', 'waka@simsarpras.test', User::ROLE_WAKA],
            ['Petugas Sarpras', 'petugas@simsarpras.test', User::ROLE_PETUGAS],
            ['Guru Contoh', 'guru@simsarpras.test', User::ROLE_GURU],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => 'password',
                    'role' => $role,
                    'is_active' => true,
                ]
            );
        }

        $kategori = [
            ['Mebeler', 'MBL'],
            ['Peralatan Elektronik', 'ELK'],
            ['Alat Praktik/Laboratorium', 'LAB'],
            ['Perlengkapan Olahraga', 'OLR'],
            ['Buku dan Media Pembelajaran', 'BKM'],
            ['Kendaraan', 'KDR'],
        ];

        foreach ($kategori as [$nama, $kode]) {
            Kategori::updateOrCreate(['kode' => $kode], ['nama' => $nama]);
        }
    }
}