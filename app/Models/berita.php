<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Berita.php
class Berita extends Model
{
    protected $fillable = ['judul', 'isi', 'gambar', 'slug'];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
        
        static::updating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
    }
}
