<?php

return [
    'admin' => [
        '*' => ['create', 'read', 'update', 'delete'],
    ],

    'kepala_sekolah' => [
        'guru' => ['create', 'read', 'update', 'delete'],
        'siswa' => ['create', 'read', 'update', 'delete'],
        'tahun_ajaran' => ['create', 'read', 'update', 'delete'],
        'materi_kbm' => ['create', 'read', 'update', 'delete'],
        'kalender_akademik' => ['create', 'read', 'update', 'delete'],
        'jadwal_pelajaran' => ['create', 'read', 'update', 'delete'],
        'ppdb' => ['create', 'read', 'update', 'delete'],
        'galeri' => ['create', 'read', 'update', 'delete'],
        'kegiatan' => ['create', 'read', 'update', 'delete'],
        'buku_tamu' => ['create', 'read', 'update', 'delete'],
        'absensi_guru' => ['create', 'read', 'update', 'delete'],
        'absensi_siswa' => ['create', 'read', 'update', 'delete'],
    ],

    'operator' => [
        'siswa' => ['create', 'read', 'update', 'delete'],
        'materi_kbm' => ['create', 'read', 'update', 'delete'],
        'kalender_akademik' => ['create', 'read', 'update', 'delete'],
        'jadwal_pelajaran' => ['create', 'read', 'update', 'delete'],
        'ppdb' => ['create', 'read', 'update', 'delete'],
        'pengumuman' => ['create', 'read', 'update', 'delete'],
        'ppdb_settings' => ['create', 'read', 'update', 'delete'],
        'galeri' => ['create', 'read', 'update', 'delete'],
        'kegiatan' => ['create', 'read', 'update', 'delete'],
        'buku_tamu' => ['create', 'read', 'update', 'delete'],
    ],

    'guru' => [
        'absensi_siswa' => ['create', 'read', 'update', 'delete'],
        'galeri' => ['create', 'read', 'update', 'delete'],
        'kegiatan' => ['create', 'read', 'update', 'delete'],
        'jadwal_pelajaran' => ['create', 'read', 'update', 'delete'],
        'materi_kbm' => ['create', 'read', 'update', 'delete'],
    ],
];
