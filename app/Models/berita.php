<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'isi_berita',
        'gambar',
        'status',
        'tanggal_publish',
        'penulis',
        'user_id'
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
    ];

    /**
     * Scope untuk berita yang sudah publish
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish')
                    ->where('tanggal_publish', '<=', now());
    }

    /**
     * Scope untuk berita terbaru
     */
    public function scopeLatestPublished($query, $limit = 5)
    {
        return $query->published()
                    ->orderBy('tanggal_publish', 'desc')
                    ->limit($limit);
    }

    /**
     * Relasi ke user (admin yang membuat)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Auto-generate slug dari judul
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = \Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = \Str::slug($berita->judul);
            }
        });
    }
}