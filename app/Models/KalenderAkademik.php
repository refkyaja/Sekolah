<?php
// app/Models/KalenderAkademik.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    use HasFactory;

    protected $table = 'kalender_akademik';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif'        => 'boolean',
    ];

    /**
     * Daftar kategori yang tersedia dengan warna Tailwind.
     */
    public static function daftarKategori(): array
    {
        return [
            'Libur Nasional'   => ['label' => '🔴 Libur Nasional',   'color' => 'red'],
            'Ujian'            => ['label' => '🟣 Ujian',            'color' => 'purple'],
            'Kegiatan Sekolah' => ['label' => '🔵 Kegiatan Sekolah', 'color' => 'blue'],
            'Rapat Guru'       => ['label' => '🟠 Rapat Guru',       'color' => 'orange'],
            'Lainnya'          => ['label' => '⚪ Lainnya',          'color' => 'slate'],
        ];
    }

    /**
     * Tailwind color classes per kategori.
     */
    public function getTailwindClassesAttribute(): array
    {
        return match ($this->kategori) {
            'Libur Nasional'   => ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'dot' => 'bg-red-500'],
            'Ujian'            => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'dot' => 'bg-purple-600'],
            'Kegiatan Sekolah' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'dot' => 'bg-blue-500'],
            'Rapat Guru'       => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'dot' => 'bg-orange-500'],
            default            => ['bg' => 'bg-slate-100',  'text' => 'text-slate-700',  'dot' => 'bg-slate-400'],
        };
    }

    /**
     * Whether the event spans multiple days.
     */
    public function getIsMultiDayAttribute(): bool
    {
        return $this->tanggal_selesai && $this->tanggal_selesai->gt($this->tanggal_mulai);
    }

    /**
     * Scope: events that fall within a given month/year.
     */
    public function scopeInMonth($query, int $year, int $month)
    {
        $start = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        return $query->where(function ($q) use ($start, $end) {
            $q->whereBetween('tanggal_mulai', [$start, $end])
              ->orWhereBetween('tanggal_selesai', [$start, $end])
              ->orWhere(function ($q2) use ($start, $end) {
                  $q2->where('tanggal_mulai', '<=', $start)
                     ->where('tanggal_selesai', '>=', $end);
              });
        });
    }
}
