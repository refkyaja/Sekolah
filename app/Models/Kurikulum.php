<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulums';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tipe',
        'ikon',
        'poin_penting',
    ];

    protected $casts = [
        'poin_penting' => 'array',
    ];
}
