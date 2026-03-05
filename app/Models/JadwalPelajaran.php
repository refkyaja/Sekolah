<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $fillable = [
        'tahun_ajaran_id',
        'semester',
        'kelompok',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'mata_pelajaran',
        'kategori',
        'lokasi',
        'guru',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
