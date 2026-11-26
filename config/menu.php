<?php

return [
    [
        'section' => 'Menu Utama',
        'items' => [
            ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'dashboard', 'active' => 'dashboard', 'roles' => ['*']],
        ],
    ],
    [
        'section' => 'Data Master',
        'items' => [
            ['label' => 'Data Prasarana', 'icon' => 'bi-building', 'route' => 'prasarana.index', 'active' => 'prasarana.*', 'roles' => ['admin', 'petugas_sarpras']],
            ['label' => 'Data Sarana', 'icon' => 'bi-box-seam', 'route' => 'sarana.index', 'active' => 'sarana.*', 'roles' => ['admin', 'petugas_sarpras']],
            ['label' => 'Kategori dan Lokasi', 'icon' => 'bi-tags', 'route' => 'kategori.index', 'active' => 'kategori.*', 'roles' => ['admin', 'petugas_sarpras']],
        ],
    ],
    [
        'section' => 'Pengelolaan Aset',
        'items' => [
            ['label' => 'Usulan Pengadaan', 'icon' => 'bi-cart-plus', 'route' => 'usulan.index', 'active' => 'usulan.*', 'roles' => ['*']],
            ['label' => 'Peminjaman', 'icon' => 'bi-arrow-left-right', 'route' => 'peminjaman.index', 'active' => 'peminjaman.*', 'roles' => ['admin', 'petugas_sarpras', 'guru']],
            ['label' => 'Kerusakan dan Pemeliharaan', 'icon' => 'bi-tools', 'route' => 'kerusakan.index', 'active' => 'kerusakan.*', 'roles' => ['admin', 'petugas_sarpras', 'guru']],
            ['label' => 'Mutasi Aset', 'icon' => 'bi-arrow-repeat', 'route' => 'mutasi.index', 'active' => 'mutasi.*', 'roles' => ['admin', 'petugas_sarpras']],
            ['label' => 'Penghapusan Aset', 'icon' => 'bi-trash3', 'route' => 'penghapusan.index', 'active' => 'penghapusan.*', 'roles' => ['admin', 'petugas_sarpras', 'kepala_sekolah']],
            ['label' => 'QR Code dan Pencarian', 'icon' => 'bi-qr-code-scan', 'route' => 'qr.index', 'active' => 'qr.*', 'roles' => ['admin', 'petugas_sarpras']],
        ],
    ],
    [
        'section' => 'Laporan',
        'items' => [
            ['label' => 'Laporan dan Ekspor', 'icon' => 'bi-file-earmark-bar-graph', 'route' => 'laporan.index', 'active' => 'laporan.*', 'roles' => ['admin', 'kepala_sekolah', 'waka_sarpras']],
        ],
    ],
    [
        'section' => 'Administrasi',
        'items' => [
            ['label' => 'Manajemen Pengguna', 'icon' => 'bi-people', 'route' => 'pengguna.index', 'active' => 'pengguna.*', 'roles' => ['admin']],
            ['label' => 'Log Aktivitas', 'icon' => 'bi-clock-history', 'route' => 'log.index', 'active' => 'log.*', 'roles' => ['admin']],
            ['label' => 'Pengaduan dan Saran', 'icon' => 'bi-chat-left-text', 'route' => 'pengaduan.index', 'active' => 'pengaduan.*', 'roles' => ['admin']],
        ],
    ],
    [
        'section' => 'Bantuan',
        'items' => [
            ['label' => 'Notifikasi', 'icon' => 'bi-bell', 'route' => 'notifikasi.index', 'active' => 'notifikasi.*', 'roles' => ['*']],
            ['label' => 'Panduan dan FAQ', 'icon' => 'bi-question-circle', 'route' => 'panduan.index', 'active' => 'panduan.*', 'roles' => ['*']],
        ],
    ],
];