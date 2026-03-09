<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',           
        'jenis_kelamin',       
        'tempat_lahir',        
        'tanggal_lahir',       
        'no_telepon',          
        'alamat',              
        'foto',                
        'last_login_at',       
        'last_login_ip',       
        'email_verified_at',   
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'tanggal_lahir' => 'date',
        'last_login_at' => 'datetime',
    ];

    // ==================== RELASI ====================
    
    // Relasi ke activity logs
    public function activities()
    {
        return $this->morphMany(Activity::class, 'causer');
    }
    
    // Relasi ke data guru
    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }
    
    // Relasi ke absensi (jika guru)
    public function absensi()
    {
        if (class_exists('\App\Models\Absensi')) {
            return $this->hasMany(\App\Models\Absensi::class, 'guru_id');
        }
        return null;
    }
    
    // ==================== SCOPE ====================
    
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
    
    public function scopeGurus($query)
    {
        return $query->where('role', 'guru');
    }
    
    // ==================== METHODS ====================
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isGuru()
    {
        return $this->role === 'guru';
    }
    
    public function hasGuruProfile()
    {
        return !is_null($this->guru);
    }
    
    public function getRoleNameAttribute()
    {
        return $this->role == 'admin' ? 'Administrator' : 'Guru';
    }
    
    public function getStatusAttribute()
    {
        return $this->isGuru() && $this->guru ? 'Aktif' : 'Aktif';
    }
    
    public function getNamaLengkapAttribute()
    {
        if ($this->isGuru() && $this->guru) {
            return $this->guru->nama ?? $this->name;
        }
        return $this->name;
    }
    
    public function getNipAttribute()
    {
        if ($this->isGuru() && $this->guru) {
            return $this->guru->nip ?? null;
        }
        return null;
    }
    
    public function getAvatarUrlAttribute()
    {
        if ($this->isGuru() && $this->guru && $this->guru->foto) {
            return asset('storage/' . $this->guru->foto);
        }
        
        // Generate avatar warna berdasarkan nama
        $colors = ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];
        $color = $colors[ord($this->name[0]) % count($colors)];
        
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&color=fff&background=" . substr($color, 1);
    }
    
    // Method untuk mereset password
    public function resetPassword($newPassword)
    {
        $this->password = bcrypt($newPassword);
        $this->save();
    }
    
    // Method untuk generate username dari nama
    public static function generateUsername($name)
    {
        $username = strtolower(str_replace(' ', '.', $name));
        $username = preg_replace('/[^a-z0-9.]/', '', $username);
        
        // Cek jika username sudah ada
        $baseUsername = $username;
        $counter = 1;
        
        while (User::where('name', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
    }
}