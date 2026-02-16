<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'absensi'; // Karena migration membuat 'absensi' bukan 'absensis'

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected $dates = ['tanggal'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'hadir' => 'success',
            'izin' => 'warning',
            'sakit' => 'info',
            'alpa' => 'danger',
            'tidak_hadir' => 'danger',
            default => 'secondary',
        };
    }
}