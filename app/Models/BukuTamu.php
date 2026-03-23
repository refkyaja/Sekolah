<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BukuTamu extends Model
{
    protected $table = 'buku_tamu';
    
    protected $fillable = [
        'nama',
        'instansi',
        'jabatan',
        'email',
        'telepon',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'tujuan_kunjungan',
        'pesan_kesan',
        'is_verified',
        'status',
        'user_id'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'blue',
            'rejected' => 'red',
            'completed' => 'green',
            default => 'gray'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => 'Unknown'
        };
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }
}