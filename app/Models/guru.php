<?php
// app/Models/Guru.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;

class Guru extends Model
{
    use HasFactory; //, LogsActivity;

    /*
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    */

    // Tentukan nama tabel (jika tidak menggunakan konvensi plural)
    protected $table = 'gurus';

    protected $fillable = [
        'nip',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'email',
        'jabatan',
        'kelompok',
        'pendidikan_terakhir',
        'foto',
        'user_id', // Tambahkan field user_id untuk relasi
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ==================== RELASI ====================
    
    // Relasi ke user account
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi ke absensi (jika ada)
    public function absensi()
    {
        if (class_exists('\App\Models\Absensi')) {
            return $this->hasMany(\App\Models\Absensi::class, 'guru_id', 'id');
        }
        return null;
    }

    // ==================== ACCESSORS ====================
    
    public function getUsiaAttribute()
    {
        if (!$this->tanggal_lahir) {
            return 0;
        }
        
        try {
            return Carbon::parse($this->tanggal_lahir)->age;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getTanggalLahirFormattedAttribute()
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }
        
        try {
            return Carbon::parse($this->tanggal_lahir)->translatedFormat('d F Y');
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getKelompokFormattedAttribute()
    {
        if (!$this->kelompok) {
            return '-';
        }
        
        return 'Kelompok ' . $this->kelompok;
    }

    public function getJabatanFormattedAttribute()
    {
        $jabatanMap = [
            'guru' => 'Guru',
            'kepsek' => 'Kepala Sekolah',
            'staff' => 'Staff',
            'wali_kelas' => 'Wali Kelas'
        ];
        
        return $jabatanMap[$this->jabatan] ?? ucfirst($this->jabatan);
    }
    
    public function getStatusAkunAttribute()
    {
        return $this->user ? 'Sudah Ada Akun' : 'Belum Ada Akun';
    }
    
    public function getEmailAkunAttribute()
    {
        return $this->user ? $this->user->email : '-';
    }

    // ==================== SCOPES ====================
    
    public function scopeByJabatan($query, $jabatan)
    {
        if ($jabatan) {
            return $query->where('jabatan', $jabatan);
        }
        return $query;
    }

    public function scopeByKelompok($query, $kelompok)
    {
        if ($kelompok) {
            return $query->where('kelompok', $kelompok);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
        }
        return $query;
    }

    // Scope untuk guru dengan akun
    public function scopeWithAccount($query)
    {
        return $query->whereNotNull('user_id');
    }
    
    // Scope untuk guru tanpa akun
    public function scopeWithoutAccount($query)
    {
        return $query->whereNull('user_id');
    }

    // Method untuk membuat akun
    public function createAccount($data = [])
    {
        // Generate email jika tidak ada
        $email = $data['email'] ?? ($this->email ?: strtolower(str_replace(' ', '.', $this->nama)) . '@tkceriabangsa.sch.id');
        
        // Generate username dari nama
        $username = User::generateUsername($this->nama);
        
        // Generate password jika tidak ada
        $password = $data['password'] ?? 'password123';
        
        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => 'guru',
        ]);

        if ($user) {
            $this->user_id = $user->id;
            $this->save();
        }

        return $user;
    }
}