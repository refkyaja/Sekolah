<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'kategori',
        'tanggal',
        'lokasi',
        'views',
        'is_published',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_published' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            $galeri->slug = Str::slug($galeri->judul);
            if (!isset($galeri->user_id) && auth()->check()) {
                $galeri->user_id = auth()->id();
            }
        });

        static::updating(function ($galeri) {
            $galeri->slug = Str::slug($galeri->judul);
        });
        
        // HAPUS OTOMATIS semua gambar beserta file-nya
        static::deleting(function ($galeri) {
            foreach ($galeri->gambar as $gambar) {
                $gambar->delete(); // Akan trigger event deleting di GambarGaleri
            }
        });
    }

    // ============= RELASI =============
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gambar()
    {
        return $this->hasMany(GambarGaleri::class)->orderBy('urutan');
    }

    // ============= ACCESSORS =============
    
    /**
     * Ambil gambar pertama sebagai thumbnail/cover
     */
    public function getThumbnailUrlAttribute()
    {
        // Ambil gambar pertama dari relasi
        $gambarPertama = $this->gambar->first();
        
        // Jika ada gambar, kembalikan URL-nya
        if ($gambarPertama) {
            return $gambarPertama->url;  // ← ini harusnya mengembalikan string URL
        }
        
        // Fallback jika tidak ada gambar
        return asset('images/no-image.jpg');
    }

    /**
     * URL thumbnail untuk ditampilkan di card
     */
    public function getThumbnailAttribute()
    {
        return $this->gambar->first();
    }

    /**
     * Kumpulan semua URL gambar
     */
    public function getGambarUrlsAttribute()
    {
        return $this->gambar->map(function($gambar) {
            return $gambar->url;
        });
    }

    /**
     * Apakah galeri memiliki gambar?
     */
    public function getHasGambarAttribute()
    {
        return $this->gambar->isNotEmpty();
    }

    /**
     * Hitung jumlah gambar
     */
    public function getJumlahGambarAttribute()
    {
        return $this->gambar->count();
    }

    // ============= SCOPES =============
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        if ($kategori) {
            return $query->where('kategori', $kategori);
        }
        return $query;
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    public function scopeTerbaru($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ============= METHODS =============
    public function incrementViews()
    {
        return $this->increment('views');
    }

    /**
     * Update urutan gambar (drag & drop)
     */
    public function updateUrutanGambar(array $urutan)
    {
        foreach ($urutan as $index => $gambarId) {
            GambarGaleri::where('id', $gambarId)
                ->where('galeri_id', $this->id)
                ->update(['urutan' => $index]);
        }
        
        return true;
    }
}