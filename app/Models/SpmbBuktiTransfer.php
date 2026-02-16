<?php
// app/Models/SpmbBuktiTransfer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbBuktiTransfer extends Model
{
    use HasFactory;

    protected $table = 'spmb_bukti_transfer';

    protected $fillable = [
        'spmb_id',
        'nama_pengirim',
        'bank_pengirim',
        'nomor_rekening_pengirim',
        'jumlah_transfer',
        'tanggal_transfer',
        'nama_file',
        'path_file',
        'status_verifikasi',
        'catatan_verifikasi',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'jumlah_transfer' => 'decimal:2',
        'tanggal_transfer' => 'date',
        'tanggal_verifikasi' => 'datetime',
    ];

    /**
     * Relasi ke SPMB
     */
    public function spmb()
    {
        return $this->belongsTo(Spmb::class, 'spmb_id');
    }

    /**
     * Relasi ke user yang memverifikasi
     */
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Scope untuk filter status verifikasi
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status_verifikasi', $status);
    }

    /**
     * Scope untuk bukti transfer yang belum diverifikasi
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status_verifikasi', 'Menunggu');
    }

    /**
     * Scope untuk bukti transfer yang sudah diverifikasi
     */
    public function scopeTerverifikasi($query)
    {
        return $query->where('status_verifikasi', 'Diverifikasi');
    }

    /**
     * Scope untuk bukti transfer yang ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', 'Ditolak');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status_verifikasi) {
            'Menunggu' => 'bg-yellow-100 text-yellow-800',
            'Diverifikasi' => 'bg-green-100 text-green-800',
            'Ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute()
    {
        return match($this->status_verifikasi) {
            'Menunggu' => 'fa-clock',
            'Diverifikasi' => 'fa-check-circle',
            'Ditolak' => 'fa-times-circle',
            default => 'fa-question-circle',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return $this->status_verifikasi;
    }

    /**
     * Get icon berdasarkan mime type file
     */
    public function getFileIconAttribute()
    {
        $extension = pathinfo($this->nama_file, PATHINFO_EXTENSION);
        
        return match(strtolower($extension)) {
            'pdf' => 'fa-file-pdf text-red-500',
            'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image text-blue-500',
            'doc', 'docx' => 'fa-file-word text-blue-700',
            'xls', 'xlsx' => 'fa-file-excel text-green-600',
            default => 'fa-file text-gray-500',
        };
    }

    /**
     * Get URL file
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path_file);
    }

    /**
     * Get formatted jumlah transfer
     */
    public function getJumlahFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_transfer, 0, ',', '.');
    }

    /**
     * Get formatted tanggal transfer
     */
    public function getTanggalTransferFormattedAttribute()
    {
        return $this->tanggal_transfer->format('d/m/Y');
    }

    /**
     * Get formatted tanggal verifikasi
     */
    public function getTanggalVerifikasiFormattedAttribute()
    {
        return $this->tanggal_verifikasi ? $this->tanggal_verifikasi->format('d/m/Y H:i') : '-';
    }

    /**
     * Verifikasi bukti transfer
     */
    public function verifikasi($userId, $catatan = null)
    {
        $this->status_verifikasi = 'Diverifikasi';
        $this->diverifikasi_oleh = $userId;
        $this->tanggal_verifikasi = now();
        $this->catatan_verifikasi = $catatan;
        $this->save();

        // Update status verifikasi bukti transfer di SPMB
        $this->spmb->verifikasi_bukti_transfer = true;
        $this->spmb->save();

        return $this;
    }

    /**
     * Tolak bukti transfer
     */
    public function tolak($userId, $catatan)
    {
        $this->status_verifikasi = 'Ditolak';
        $this->diverifikasi_oleh = $userId;
        $this->tanggal_verifikasi = now();
        $this->catatan_verifikasi = $catatan;
        $this->save();

        // Update status verifikasi bukti transfer di SPMB
        $this->spmb->verifikasi_bukti_transfer = false;
        $this->spmb->save();

        return $this;
    }
}