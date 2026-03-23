<?php
// app/Models/SpmbDokumen.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbDokumen extends Model
{
    use HasFactory;

    protected $table = 'spmb_dokumen';

    protected $fillable = [
        'spmb_id',
        'jenis_dokumen',
        'nama_file',
        'path_file',
        'mime_type',
        'ukuran_file',
        'keterangan',
    ];

    protected $casts = [
        'ukuran_file' => 'integer',
    ];

    /**
     * Relasi ke SPMB
     */
    public function spmb()
    {
        return $this->belongsTo(Spmb::class, 'spmb_id');
    }


    /**
     * Scope untuk filter jenis dokumen
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_dokumen', $jenis);
    }

    /**
     * Get icon berdasarkan mime type
     */
    public function getIconAttribute()
    {
        if (str_contains($this->mime_type, 'pdf')) {
            return 'fa-file-pdf text-red-500';
        } elseif (str_contains($this->mime_type, 'image')) {
            return 'fa-file-image text-blue-500';
        } elseif (str_contains($this->mime_type, 'word') || str_contains($this->mime_type, 'document')) {
            return 'fa-file-word text-blue-700';
        } elseif (str_contains($this->mime_type, 'excel') || str_contains($this->mime_type, 'sheet')) {
            return 'fa-file-excel text-green-600';
        } else {
            return 'fa-file text-gray-500';
        }
    }

    /**
     * Get label jenis dokumen
     */
    public function getJenisLabelAttribute()
    {
        $labels = [
            'akte' => 'Akta Kelahiran',
            'kk' => 'Kartu Keluarga',
            'ktp' => 'KTP Orang Tua',
            'bukti_transfer' => 'Bukti Transfer',
            'kartu_bantuan' => 'Kartu Bantuan',
        ];

        return $labels[$this->jenis_dokumen] ?? ucfirst($this->jenis_dokumen);
    }

    /**
     * Get ukuran file dalam format yang mudah dibaca
     */
    public function getUkuranFormattedAttribute()
    {
        if ($this->ukuran_file < 1024) {
            return $this->ukuran_file . ' KB';
        } else {
            return round($this->ukuran_file / 1024, 2) . ' MB';
        }
    }

    /**
     * Get URL file
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path_file);
    }
}