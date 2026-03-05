<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'sambutan_judul',
        'sambutan_teks',
        'kepsek_nama',
        'kepsek_foto',
        'visi',
        'misi',
        'sejarah',
        'npsn',
        'status_akreditasi',
        'alamat',
        'kurikulum',
        'telepon',
        'email',
    ];

    protected $casts = [
        'misi' => 'array',
    ];
}
