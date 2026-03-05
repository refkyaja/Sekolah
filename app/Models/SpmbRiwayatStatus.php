<?php
// app/Models/SpmbRiwayatStatus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbRiwayatStatus extends Model
{
    use HasFactory;

    protected $table = 'spmb_riwayat_status';

    protected $fillable = [
        'spmb_id',
        'status_sebelumnya',
        'status_baru',
        'keterangan',
        'diubah_oleh',
        'role_pengubah',
    ];

    /**
     * Relasi ke SPMB
     */
    public function spmb()
    {
        return $this->belongsTo(Spmb::class, 'spmb_id');
    }

    /**
     * Relasi ke user yang mengubah
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }

    /**
     * Get status sebelumnya badge
     */
    public function getStatusSebelumnyaBadgeAttribute()
    {
        return match($this->status_sebelumnya) {
            'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-800',
            'Revisi Dokumen' => 'bg-orange-100 text-orange-800',
            'Dokumen Verified' => 'bg-blue-100 text-blue-800',
            'Lulus' => 'bg-green-100 text-green-800',
            'Tidak Lulus' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status baru badge
     */
    public function getStatusBaruBadgeAttribute()
    {
        return match($this->status_baru) {
            'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-800',
            'Revisi Dokumen' => 'bg-orange-100 text-orange-800',
            'Dokumen Verified' => 'bg-blue-100 text-blue-800',
            'Lulus' => 'bg-green-100 text-green-800',
            'Tidak Lulus' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get formatted tanggal
     */
    public function getTanggalFormattedAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}