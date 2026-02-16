<?php
// app/Models/TahunAjaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajarans';

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'is_aktif',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Relasi ke SPMB
     */
    public function spmb()
    {
        return $this->hasMany(Spmb::class, 'tahun_ajaran_id');
    }

    /**
     * Scope untuk tahun ajaran aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Format tahun ajaran untuk display
     */
    public function getLabelAttribute()
    {
        return $this->tahun_ajaran . ' - Semester ' . $this->semester;
    }
}