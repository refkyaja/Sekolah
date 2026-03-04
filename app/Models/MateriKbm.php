<?php
// app/Models/MateriKbm.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriKbm extends Model
{
    use HasFactory;

    protected $table = 'materi_kbm';

    protected $fillable = [
        'mata_pelajaran',
        'judul_materi',
        'kelas',
        'kelompok',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'deskripsi',
        'tanggal_publish',
        'guru_id',
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
        'file_size'       => 'integer',
    ];

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(guru::class, 'guru_id');
    }

    /**
     * Accessor: ukuran file dalam format yang mudah dibaca (e.g. 2.4 MB)
     */
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '-';
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 1)    . ' KB';
        return $bytes . ' B';
    }

    /**
     * Accessor: label kelas lengkap
     */
    public function getKelasLengkapAttribute(): string
    {
        return $this->kelompok
            ? "{$this->kelas} - {$this->kelompok}"
            : $this->kelas;
    }

    /**
     * Daftar mata pelajaran yang tersedia
     */
    public static function daftarMataPelajaran(): array
    {
        return [
            'Baca',
            'Tulis',
            'Menghitung',
        ];
    }

    /**
     * Daftar kelas yang tersedia
     */
    public static function daftarKelas(): array
    {
        return ['Kelompok A', 'Kelompok B'];
    }
}
