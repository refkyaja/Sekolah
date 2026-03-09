<?php
// app/Models/Spmb.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Spmb extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'spmb';

    protected $fillable = [
        'no_pendaftaran',
        'tahun_ajaran_id',
        'status_pendaftaran',
        'no_registrasi',
        'nisn',
        'catatan_daftar_ulang',
        'tanggal_mulai_daftar_ulang',
        'tanggal_selesai_daftar_ulang',
        
        // Data Anak (Bagian 1)
        'nama_lengkap_anak',
        'nama_panggilan_anak',
        'nik_anak',
        'tempat_lahir_anak',
        'tanggal_lahir_anak',
        'provinsi_rumah',
        'kota_kabupaten_rumah',
        'kecamatan_rumah',
        'kelurahan_rumah',
        'nama_jalan_rumah',
        'alamat_kk_sama',
        'alamat_kk',
        'provinsi_kk',
        'kota_kabupaten_kk',
        'kecamatan_kk',
        'kelurahan_kk',
        'nama_jalan_kk',
        'jenis_kelamin',
        'agama',
        'anak_ke',
        'tinggal_bersama',
        'status_tempat_tinggal',
        'bahasa_sehari_hari',
        'jarak_rumah_ke_sekolah',
        'waktu_tempuh_ke_sekolah',
        'berat_badan',
        'tinggi_badan',
        'golongan_darah',
        'penyakit_pernah_diderita',
        'imunisasi_pernah_diterima',
        
        // Data Ayah
        'nama_lengkap_ayah',
        'nik_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'alamat_ayah',
        'provinsi_ayah',
        'kota_kabupaten_ayah',
        'kecamatan_ayah',
        'kelurahan_ayah',
        'nama_jalan_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'bidang_pekerjaan_ayah',
        'penghasilan_per_bulan_ayah',
        'nomor_telepon_ayah',
        'email_ayah',
        
        // Data Ibu
        'nama_lengkap_ibu',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'alamat_ibu',
        'provinsi_ibu',
        'kota_kabupaten_ibu',
        'kecamatan_ibu',
        'kelurahan_ibu',
        'nama_jalan_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'bidang_pekerjaan_ibu',
        'penghasilan_per_bulan_ibu',
        'nomor_telepon_ibu',
        'email_ibu',
        
        // Data Wali
        'punya_wali',
        'nama_lengkap_wali',
        'hubungan_dengan_anak',
        'nik_wali',
        'tempat_lahir_wali',
        'tanggal_lahir_wali',
        'alamat_wali',
        'provinsi_wali',
        'kota_kabupaten_wali',
        'kecamatan_wali',
        'kelurahan_wali',
        'nama_jalan_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'bidang_pekerjaan_wali',
        'penghasilan_per_bulan_wali',
        'nomor_telepon_wali',
        'email_wali',
        
        // Informasi Tambahan
        'sumber_informasi_ppdb',
        'punya_saudara_sekolah_tk',
        'jenis_daftar',
        
        // Verifikasi Dokumen
        'verifikasi_akte',
        'verifikasi_kk',
        'verifikasi_ktp',
        'verifikasi_bukti_transfer',
        'tanggal_verifikasi_akte',
        'tanggal_verifikasi_kk',
        'tanggal_verifikasi_ktp',
        'tanggal_verifikasi_bukti_transfer',
        'diverifikasi_oleh',
        
        // Approval Kepala Sekolah
        'approved_by_kepsek',
        'kepsek_id',
        'tanggal_approval',
        
        // Data Kelas
        'kelas',
        'guru_kelas',
        'operator_input_kelas',
        
        // Data Siswa Aktif
        'is_aktif',
        'nomor_induk_siswa',
        'is_lulus',
        'is_mengulang',
        'catatan_admin',
        'foto_calon_siswa',
    ];

    protected $casts = [
        'tanggal_lahir_anak' => 'date',
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu' => 'date',
        'tanggal_lahir_wali' => 'date',
        'tanggal_mulai_daftar_ulang' => 'date',
        'tanggal_selesai_daftar_ulang' => 'date',
        'tanggal_verifikasi_akte' => 'datetime',
        'tanggal_verifikasi_kk' => 'datetime',
        'tanggal_verifikasi_ktp' => 'datetime',
        'tanggal_verifikasi_bukti_transfer' => 'datetime',
        'tanggal_approval' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'alamat_kk_sama' => 'boolean',
        'punya_wali' => 'boolean',
        'verifikasi_akte' => 'boolean',
        'verifikasi_kk' => 'boolean',
        'verifikasi_ktp' => 'boolean',
        'verifikasi_bukti_transfer' => 'boolean',
        'approved_by_kepsek' => 'boolean',
        'is_aktif' => 'boolean',
        'is_lulus' => 'boolean',
        'is_mengulang' => 'boolean',
    ];

    /**
     * KONSTANTA untuk options dropdown - SATU SUMBER KEBENARAN
     */
    const TINGGAL_BERSAMA_OPTIONS = [
        'Ayah dan Ibu',
        'Ayah',
        'Ibu',
        'Keluarga Ayah',
        'Keluarga Ibu',
        'Lainnya'
    ];

    const STATUS_TEMPAT_TINGGAL_OPTIONS = [
        'Milik Sendiri',
        'Milik Keluarga',
        'Kontrakan'
    ];

    const PEKERJAAN_AYAH_OPTIONS = [
        'Pekerja Informal',
        'Wirausaha',
        'Pegawai Swasta',
        'PNS'
    ];

    const PEKERJAAN_IBU_OPTIONS = [
        'Ibu Rumah Tangga',
        'Pekerja Informal',
        'Wirausaha',
        'Pegawai Swasta',
        'PNS'
    ];

    const PUNYA_SAUDARA_SEKOLAH_TK_OPTIONS = ['Ya', 'Tidak'];
    const JENIS_DAFTAR_OPTIONS = ['Siswa Baru', 'Pindahan'];
    const JENIS_KELAMIN_OPTIONS = ['Laki-laki', 'Perempuan'];
    const AGAMA_OPTIONS = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
    const GOLONGAN_DARAH_OPTIONS = ['A', 'B', 'AB', 'O'];
    const HUBUNGAN_WALI_OPTIONS = ['Kakek', 'Nenek', 'Paman', 'Bibi', 'Kakak', 'Lainnya'];
    const SUMBER_INFORMASI_OPTIONS = ['Media Sosial', 'Website Sekolah', 'Spanduk/Baliho', 'Teman/Keluarga', 'Guru', 'Lainnya'];

    // Boot method untuk generate no_pendaftaran otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_pendaftaran)) {
                $tahun = date('Y');
                $latest = self::withTrashed()
                    ->whereYear('created_at', $tahun)
                    ->orderBy('id', 'desc')
                    ->first();
                
                if ($latest && preg_match('/PPDB-\d{4}-(\d+)/', $latest->no_pendaftaran, $matches)) {
                    $urutan = (int)$matches[1] + 1;
                } else {
                    $urutan = 1;
                }
                
                $model->no_pendaftaran = "PPDB-{$tahun}-" . str_pad($urutan, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Relationships
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function kepalaSekolah()
    {
        return $this->belongsTo(User::class, 'kepsek_id');
    }

    public function operatorKelas()
    {
        return $this->belongsTo(User::class, 'operator_input_kelas');
    }

    public function dokumen()
    {
        return $this->hasMany(SpmbDokumen::class, 'spmb_id');
    }

    public function riwayatStatus()
    {
        return $this->hasMany(SpmbRiwayatStatus::class, 'spmb_id');
    }

    public function buktiTransfer()
    {
        return $this->hasMany(SpmbBuktiTransfer::class, 'spmb_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'spmb_id');
    }

    // Accessors
    public function getUsiaAnakAttribute()
    {
        if (!$this->tanggal_lahir_anak) return 0;
        return Carbon::parse($this->tanggal_lahir_anak)->age;
    }

    public function getUsiaDalamBulanAttribute()
    {
        if (!$this->tanggal_lahir_anak) return 0;
        return Carbon::parse($this->tanggal_lahir_anak)->diffInMonths(now());
    }

    public function getUsiaLabelAttribute()
    {
        $tahun = floor($this->usia_dalam_bulan / 12);
        $bulan = $this->usia_dalam_bulan % 12;
        return "{$tahun} th {$bulan} bln";
    }

    public function getRekomendasiKelompokAttribute()
    {
        $usia = $this->usia_anak;
        if ($usia >= 3 && $usia <= 4) {
            return 'A';
        } elseif ($usia >= 5 && $usia <= 6) {
            return 'B';
        }
        return 'Belum Memenuhi Syarat';
    }

    public function getStatusPendaftaranLabelAttribute()
    {
        $labels = [
            'Menunggu Verifikasi' => 'Menunggu Verifikasi',
            'Revisi Dokumen' => 'Revisi Dokumen',
            'Dokumen Verified' => 'Dokumen Verified',
            'Lulus' => 'Lulus',
            'Tidak Lulus' => 'Tidak Lulus',
        ];
        return $labels[$this->status_pendaftaran] ?? $this->status_pendaftaran;
    }

    public function getStatusPendaftaranColorAttribute()
    {
        $colors = [
            'Menunggu Verifikasi' => 'yellow',
            'Revisi Dokumen' => 'orange',
            'Dokumen Verified' => 'blue',
            'Lulus' => 'green',
            'Tidak Lulus' => 'red',
        ];
        return $colors[$this->status_pendaftaran] ?? 'gray';
    }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin;
    }

    public function getNamaOrangTuaAttribute()
    {
        return $this->nama_lengkap_ayah . ' & ' . $this->nama_lengkap_ibu;
    }

    public function getNoTeleponOrtuAttribute()
    {
        return $this->nomor_telepon_ayah ?? $this->nomor_telepon_ibu;
    }

    public function getEmailOrtuAttribute()
    {
        return $this->email_ayah ?? $this->email_ibu;
    }

    public function getProgressVerifikasiAttribute()
    {
        $total = 3; // Akte, KK, KTP
        $terverifikasi = 0;
        
        if ($this->verifikasi_akte) $terverifikasi++;
        if ($this->verifikasi_kk) $terverifikasi++;
        if ($this->verifikasi_ktp) $terverifikasi++;
        
        return [
            'total' => $total,
            'terverifikasi' => $terverifikasi,
            'persentase' => round(($terverifikasi / $total) * 100)
        ];
    }

    public function getDokumenLengkapAttribute()
    {
        return $this->verifikasi_akte && $this->verifikasi_kk && $this->verifikasi_ktp;
    }

    public function getSiapLulusAttribute()
    {
        return $this->dokumen_lengkap && $this->verifikasi_bukti_transfer && $this->approved_by_kepsek;
    }

    // Accessors untuk field baru - konsisten dengan konstanta
    public function getTinggalBersamaLabelAttribute()
    {
        return $this->tinggal_bersama ?? 'Lainnya';
    }

    public function getStatusTempatTinggalLabelAttribute()
    {
        return $this->status_tempat_tinggal ?? '-';
    }

    public function getPekerjaanAyahLabelAttribute()
    {
        return $this->pekerjaan_ayah ?? '-';
    }

    public function getPekerjaanIbuLabelAttribute()
    {
        return $this->pekerjaan_ibu ?? '-';
    }

    public function getPunyaSaudaraSekolahTkLabelAttribute()
    {
        return $this->punya_saudara_sekolah_tk ?? 'Tidak';
    }

    // Scopes
    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        if ($tahunAjaranId) {
            return $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status_pendaftaran', $status);
        }
        return $query;
    }

    public function scopeByJenisKelamin($query, $jk)
    {
        if ($jk) {
            return $query->where('jenis_kelamin', $jk);
        }
        return $query;
    }

    public function scopeByTinggalBersama($query, $value)
    {
        if ($value) {
            return $query->where('tinggal_bersama', $value);
        }
        return $query;
    }

    public function scopeByStatusTempatTinggal($query, $value)
    {
        if ($value) {
            return $query->where('status_tempat_tinggal', $value);
        }
        return $query;
    }

    public function scopeByPekerjaanAyah($query, $value)
    {
        if ($value) {
            return $query->where('pekerjaan_ayah', $value);
        }
        return $query;
    }

    public function scopeByPekerjaanIbu($query, $value)
    {
        if ($value) {
            return $query->where('pekerjaan_ibu', $value);
        }
        return $query;
    }

    public function scopeByPunyaSaudaraSekolahTk($query, $value)
    {
        if ($value) {
            return $query->where('punya_saudara_sekolah_tk', $value);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('nama_lengkap_anak', 'like', "%{$search}%")
                  ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('nik_anak', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap_ayah', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap_ibu', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon_ayah', 'like', "%{$search}%")
                  ->orWhere('nomor_telepon_ibu', 'like', "%{$search}%")
                  ->orWhere('email_ayah', 'like', "%{$search}%")
                  ->orWhere('email_ibu', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status_pendaftaran', 'Menunggu Verifikasi');
    }

    public function scopeLulus($query)
    {
        return $query->where('status_pendaftaran', 'Lulus');
    }

    public function scopeTidakLulus($query)
    {
        return $query->where('status_pendaftaran', 'Tidak Lulus');
    }

    public function scopeDokumenLengkap($query)
    {
        return $query->where('verifikasi_akte', true)
                     ->where('verifikasi_kk', true)
                     ->where('verifikasi_ktp', true);
    }

    public function scopeDokumenBelumLengkap($query)
    {
        return $query->where(function($q) {
            $q->where('verifikasi_akte', false)
              ->orWhere('verifikasi_kk', false)
              ->orWhere('verifikasi_ktp', false);
        });
    }

    public function scopeSiswaAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeBelumAdaKelas($query)
    {
        return $query->whereNull('kelas');
    }

    public function scopeSudahAdaKelas($query)
    {
        return $query->whereNotNull('kelas');
    }

    // Methods
    public function setStatus($status, $userId = null, $catatan = null)
    {
        $oldStatus = $this->status_pendaftaran;
        $this->status_pendaftaran = $status;
        $this->save();

        if ($userId) {
            $this->riwayatStatus()->create([
                'status_sebelumnya' => $oldStatus,
                'status_baru' => $status,
                'keterangan' => $catatan,
                'diubah_oleh' => $userId,
                'role_pengubah' => $this->getRoleUser($userId)
            ]);
        }

        return $this;
    }

    public function verifikasiDokumen($jenis, $userId)
    {
        $field = 'verifikasi_' . $jenis;
        $tanggalField = 'tanggal_verifikasi_' . $jenis;
        
        $this->$field = true;
        $this->$tanggalField = now();
        $this->diverifikasi_oleh = $userId;
        $this->save();

        return $this;
    }

    public function approveKepsek($userId)
    {
        $this->approved_by_kepsek = true;
        $this->kepsek_id = $userId;
        $this->tanggal_approval = now();
        
        if ($this->dokumen_lengkap && $this->verifikasi_bukti_transfer) {
            $this->status_pendaftaran = 'Lulus';
        }
        
        $this->save();

        return $this;
    }

    public function aktifkanSiswa($nomorInduk = null)
    {
        $this->is_aktif = true;
        if ($nomorInduk) {
            $this->nomor_induk_siswa = $nomorInduk;
        } else {
            $tahun = date('Y');
            $urutan = self::whereYear('created_at', $tahun)->count() + 1;
            $this->nomor_induk_siswa = "NIS-{$tahun}-" . str_pad($urutan, 5, '0', STR_PAD_LEFT);
        }
        $this->save();

        return $this;
    }

    public function nonaktifkanSiswa()
    {
        $this->is_aktif = false;
        $this->save();

        return $this;
    }

    public function setLulus()
    {
        $this->is_lulus = true;
        $this->is_aktif = false;
        $this->save();

        return $this;
    }

    public function setMengulang()
    {
        $this->is_mengulang = true;
        $this->save();

        return $this;
    }

    public function assignKelas($kelas, $guruKelas, $operatorId)
    {
        $this->kelas = $kelas;
        $this->guru_kelas = $guruKelas;
        $this->operator_input_kelas = $operatorId;
        $this->save();

        return $this;
    }

    protected function getRoleUser($userId)
    {
        $user = User::find($userId);
        return $user ? $user->role : 'unknown';
    }

    // Static Methods - Statistik dengan konsistensi
    public static function getStatistik($tahunAjaranId = null)
    {
        $query = self::query();
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        return [
            'total' => $query->count(),
            'menunggu' => (clone $query)->where('status_pendaftaran', 'Menunggu Verifikasi')->count(),
            'diterima' => (clone $query)->where('status_pendaftaran', 'Lulus')->count(),
            'mundur' => (clone $query)->where('status_pendaftaran', 'Tidak Lulus')->count(),
            'dokumen_lengkap' => (clone $query)->dokumenLengkap()->count(),
            'dokumen_belum_lengkap' => (clone $query)->dokumenBelumLengkap()->count(),
            'siswa_aktif' => (clone $query)->siswaAktif()->count(),
            'laki_laki' => (clone $query)->where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => (clone $query)->where('jenis_kelamin', 'Perempuan')->count(),
            
            // Statistik tinggal bersama - konsisten dengan 6 opsi
            'tinggal_dengan_ayah_ibu' => (clone $query)->where('tinggal_bersama', 'Ayah dan Ibu')->count(),
            'tinggal_dengan_ayah' => (clone $query)->where('tinggal_bersama', 'Ayah')->count(),
            'tinggal_dengan_ibu' => (clone $query)->where('tinggal_bersama', 'Ibu')->count(),
            'tinggal_dengan_keluarga_ayah' => (clone $query)->where('tinggal_bersama', 'Keluarga Ayah')->count(),
            'tinggal_dengan_keluarga_ibu' => (clone $query)->where('tinggal_bersama', 'Keluarga Ibu')->count(),
            'tinggal_lainnya' => (clone $query)->where('tinggal_bersama', 'Lainnya')->count(),
            
            // Status tempat tinggal
            'status_rumah_milik_sendiri' => (clone $query)->where('status_tempat_tinggal', 'Milik Sendiri')->count(),
            'status_rumah_milik_keluarga' => (clone $query)->where('status_tempat_tinggal', 'Milik Keluarga')->count(),
            'status_rumah_kontrakan' => (clone $query)->where('status_tempat_tinggal', 'Kontrakan')->count(),
            
            // Pekerjaan ayah
            'pekerjaan_ayah_informal' => (clone $query)->where('pekerjaan_ayah', 'Pekerja Informal')->count(),
            'pekerjaan_ayah_wirausaha' => (clone $query)->where('pekerjaan_ayah', 'Wirausaha')->count(),
            'pekerjaan_ayah_swasta' => (clone $query)->where('pekerjaan_ayah', 'Pegawai Swasta')->count(),
            'pekerjaan_ayah_pns' => (clone $query)->where('pekerjaan_ayah', 'PNS')->count(),
            
            // Pekerjaan ibu
            'pekerjaan_ibu_rumah_tangga' => (clone $query)->where('pekerjaan_ibu', 'Ibu Rumah Tangga')->count(),
            'pekerjaan_ibu_informal' => (clone $query)->where('pekerjaan_ibu', 'Pekerja Informal')->count(),
            'pekerjaan_ibu_wirausaha' => (clone $query)->where('pekerjaan_ibu', 'Wirausaha')->count(),
            'pekerjaan_ibu_swasta' => (clone $query)->where('pekerjaan_ibu', 'Pegawai Swasta')->count(),
            'pekerjaan_ibu_pns' => (clone $query)->where('pekerjaan_ibu', 'PNS')->count(),
        ];
    }

    public static function getJumlahSiswaPerKelas($tahunAjaranId = null)
    {
        $query = self::where('status_pendaftaran', 'Lulus')
            ->whereNotNull('kelas')
            ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId));
        
        return [
            'kelompok_a' => (clone $query)->where('kelas', 'Kelompok A')->count(),
            'kelompok_b' => (clone $query)->where('kelas', 'Kelompok B')->count(),
            'total' => (clone $query)->count(),
        ];
    }
}