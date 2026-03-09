<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpmbArsip extends Model
{
    use SoftDeletes;

    protected $table = 'spmb_arsip';

    protected $fillable = [
        'spmb_asli_id',
        'no_pendaftaran',
        'tahun_ajaran_id',
        'nama_lengkap_anak',
        'nik_anak',
        'jenis_kelamin',
        'tanggal_lahir_anak',
        'status_pendaftaran',
        'is_aktif',
        'nomor_induk_siswa',
        'data_lengkap',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'data_lengkap' => 'array',
        'tanggal_lahir_anak' => 'date',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
