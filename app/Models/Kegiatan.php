<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'tanggal', 'kategori', 'foto', 'slug'];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($kegiatan) {
            $kegiatan->slug = Str::slug($kegiatan->judul) . '-' . Str::random(5);
        });
        
        static::updating(function ($kegiatan) {
            $kegiatan->slug = Str::slug($kegiatan->judul) . '-' . Str::random(5);
        });
    }
}