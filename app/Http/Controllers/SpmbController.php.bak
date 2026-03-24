<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\SpmbDokumen;
use App\Models\SpmbSetting;
use App\Models\TahunAjaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SpmbController extends Controller
{
    /**
     * ADMIN SECTION
     */
    
    /**
     * Halaman index SPMB untuk admin
     */
    public function adminIndex()
    {
        $spmb = Spmb::with(['tahunAjaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        return view('admin.ppdb.index', compact('spmb', 'tahunAjaran'));
    }

    /**
     * Halaman create SPMB untuk admin
     */
    public function adminCreate()
    {
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        return view('admin.ppdb.create', compact('tahunAjaran', 'tahunAjaranAktif'));
    }

    /**
     * Simpan data SPMB dari admin
     */
    public function adminStore(Request $request)
    {
        // Debug: lihat data yang dikirim
        \Log::info('Admin SPMB Store Request:', $request->all());
        
        // Validasi data
        $validator = Validator::make($request->all(), [
            // Data Anak (Bagian 1) - semuanya string tanpa in kecuali yang benar-benar perlu
            'nama_lengkap_anak' => 'required|string|max:255',
            'nama_panggilan_anak' => 'nullable|string|max:100',
            'nik_anak' => 'required|string|max:20|unique:spmb,nik_anak',
            'tempat_lahir_anak' => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen Protestan,Kristen Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'anak_ke' => 'required|integer|min:1',
            'tinggal_bersama' => 'required|string|max:100',
            'status_tempat_tinggal' => 'required|string|max:100',
            'bahasa_sehari_hari' => 'required|string|max:100',
            'jarak_rumah_ke_sekolah' => 'nullable|integer',
            'waktu_tempuh_ke_sekolah' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'golongan_darah' => 'nullable|string|max:10',
            'penyakit_pernah_diderita' => 'nullable|string',
            'imunisasi_pernah_diterima' => 'nullable|string',
            
            // Alamat Rumah
            'provinsi_rumah' => 'required|string|max:100',
            'kota_kabupaten_rumah' => 'required|string|max:100',
            'kecamatan_rumah' => 'required|string|max:100',
            'kelurahan_rumah' => 'required|string|max:100',
            'nama_jalan_rumah' => 'required|string|max:255',
            
            // Alamat KK
            'alamat_kk_sama' => 'nullable|boolean',
            'provinsi_kk' => 'nullable|string|max:100',
            'kota_kabupaten_kk' => 'nullable|string|max:100',
            'kecamatan_kk' => 'nullable|string|max:100',
            'kelurahan_kk' => 'nullable|string|max:100',
            'nama_jalan_kk' => 'nullable|string|max:255',
            'alamat_kk' => 'nullable|string',
            
            // Data Ayah
            'nama_lengkap_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|string|max:20',
            'tempat_lahir_ayah' => 'required|string|max:100',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'bidang_pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_per_bulan_ayah' => 'nullable|string|max:100',
            'nomor_telepon_ayah' => 'required|string|max:20',
            'email_ayah' => 'nullable|email|max:255',
            
            // Data Ibu
            'nama_lengkap_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|string|max:20',
            'tempat_lahir_ibu' => 'required|string|max:100',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'bidang_pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_per_bulan_ibu' => 'nullable|string|max:100',
            'nomor_telepon_ibu' => 'required|string|max:20',
            'email_ibu' => 'nullable|email|max:255',
            
            // Data Wali
            'punya_wali' => 'nullable|boolean',
            'nama_lengkap_wali' => 'nullable|string|max:255',
            'hubungan_dengan_anak' => 'nullable|string|max:100',
            'nik_wali' => 'nullable|string|max:20',
            'tempat_lahir_wali' => 'nullable|string|max:100',
            'tanggal_lahir_wali' => 'nullable|date',
            'pendidikan_wali' => 'nullable|string|max:100',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'nomor_telepon_wali' => 'nullable|string|max:20',
            'email_wali' => 'nullable|email|max:255',
            
            // Informasi Tambahan
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jenis_daftar' => 'required|in:Siswa Baru,Pindahan',
            'sumber_informasi_ppdb' => 'nullable|string|max:255',
            'punya_saudara_sekolah_tk' => 'required|in:Ya,Tidak',
            
            // Dokumen
            'akte_kelahiran' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'kartu_keluarga' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'ktp_orang_tua' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ], [
            'nik_anak.max' => 'NIK anak maksimal 20 karakter',
            'nik_anak.unique' => 'NIK ini sudah terdaftar',
            'nik_ayah.max' => 'NIK ayah maksimal 20 karakter',
            'nik_ibu.max' => 'NIK ibu maksimal 20 karakter',
            'nik_wali.max' => 'NIK wali maksimal 20 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.ppdb.create')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        
        try {
            // Generate nomor pendaftaran
            $noPendaftaran = $this->generateNomorPendaftaran();
            
            // Siapkan data untuk disimpan
            $spmbData = [
                'no_pendaftaran' => $noPendaftaran,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'status_pendaftaran' => 'Menunggu Verifikasi',
                
                // Data Anak
                'nama_lengkap_anak' => $request->nama_lengkap_anak,
                'nama_panggilan_anak' => $request->nama_panggilan_anak,
                'nik_anak' => $request->nik_anak,
                'tempat_lahir_anak' => $request->tempat_lahir_anak,
                'tanggal_lahir_anak' => $request->tanggal_lahir_anak,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'anak_ke' => $request->anak_ke,
                'tinggal_bersama' => $request->tinggal_bersama,
                'status_tempat_tinggal' => $request->status_tempat_tinggal,
                'bahasa_sehari_hari' => $request->bahasa_sehari_hari,
                'jarak_rumah_ke_sekolah' => $request->jarak_rumah_ke_sekolah,
                'waktu_tempuh_ke_sekolah' => $request->waktu_tempuh_ke_sekolah,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'golongan_darah' => $request->golongan_darah,
                'penyakit_pernah_diderita' => $request->penyakit_pernah_diderita,
                'imunisasi_pernah_diterima' => $request->imunisasi_pernah_diterima,
                
                // Alamat Rumah
                'provinsi_rumah' => $request->provinsi_rumah,
                'kota_kabupaten_rumah' => $request->kota_kabupaten_rumah,
                'kecamatan_rumah' => $request->kecamatan_rumah,
                'kelurahan_rumah' => $request->kelurahan_rumah,
                'nama_jalan_rumah' => $request->nama_jalan_rumah,
                
                // Alamat KK
                'alamat_kk_sama' => $request->has('alamat_kk_sama'),
                'provinsi_kk' => $request->provinsi_kk,
                'kota_kabupaten_kk' => $request->kota_kabupaten_kk,
                'kecamatan_kk' => $request->kecamatan_kk,
                'kelurahan_kk' => $request->kelurahan_kk,
                'nama_jalan_kk' => $request->nama_jalan_kk,
                'alamat_kk' => $request->alamat_kk,
                
                // Data Ayah
                'nama_lengkap_ayah' => $request->nama_lengkap_ayah,
                'nik_ayah' => $request->nik_ayah,
                'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'bidang_pekerjaan_ayah' => $request->bidang_pekerjaan_ayah,
                'penghasilan_per_bulan_ayah' => $request->penghasilan_per_bulan_ayah,
                'nomor_telepon_ayah' => $request->nomor_telepon_ayah,
                'email_ayah' => $request->email_ayah,
                
                // Data Ibu
                'nama_lengkap_ibu' => $request->nama_lengkap_ibu,
                'nik_ibu' => $request->nik_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'bidang_pekerjaan_ibu' => $request->bidang_pekerjaan_ibu,
                'penghasilan_per_bulan_ibu' => $request->penghasilan_per_bulan_ibu,
                'nomor_telepon_ibu' => $request->nomor_telepon_ibu,
                'email_ibu' => $request->email_ibu,
                
                // Data Wali
                'punya_wali' => $request->has('punya_wali'),
                'nama_lengkap_wali' => $request->nama_lengkap_wali,
                'hubungan_dengan_anak' => $request->hubungan_dengan_anak,
                'nik_wali' => $request->nik_wali,
                'tempat_lahir_wali' => $request->tempat_lahir_wali,
                'tanggal_lahir_wali' => $request->tanggal_lahir_wali,
                'pendidikan_wali' => $request->pendidikan_wali,
                'pekerjaan_wali' => $request->pekerjaan_wali,
                'nomor_telepon_wali' => $request->nomor_telepon_wali,
                'email_wali' => $request->email_wali,
                
                // Informasi Tambahan
                'sumber_informasi_ppdb' => $request->sumber_informasi_ppdb,
                'punya_saudara_sekolah_tk' => $request->punya_saudara_sekolah_tk,
                'jenis_daftar' => $request->jenis_daftar,
                
                // Status Verifikasi Dokumen (default false)
                'verifikasi_akte' => false,
                'verifikasi_kk' => false,
                'verifikasi_ktp' => false,
                'verifikasi_bukti_transfer' => false,
            ];
            
            // Buat record SPMB
            $spmb = Spmb::create($spmbData);
            
            // Upload dokumen jika ada
            if ($request->hasFile('akte_kelahiran') || $request->hasFile('kartu_keluarga') || $request->hasFile('ktp_orang_tua')) {
                $this->handleDokumenUploads($request, $spmb);
            }
            
            DB::commit();
            
            return redirect()->route('admin.ppdb.index')
                ->with('success', 'Data pendaftaran SPMB berhasil ditambahkan. Nomor Pendaftaran: ' . $noPendaftaran);
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin SPMB Store Error: ' . $e->getMessage());
            Log::error('Admin SPMB Store Trace: ' . $e->getTraceAsString());
            
            return redirect()->route('admin.ppdb.create')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Halaman detail SPMB untuk admin
     */
    public function adminShow($id)
    {
        $spmb = Spmb::with(['tahunAjaran', 'dokumen'])->findOrFail($id);
        
        return view('admin.ppdb.show', compact('spmb'));
    }

    /**
     * Halaman edit SPMB untuk admin
     */
    public function adminEdit($id)
    {
        $spmb = Spmb::with('dokumen')->findOrFail($id);
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        return view('admin.ppdb.edit', compact('spmb', 'tahunAjaran'));
    }

    /**
     * Update data SPMB dari admin
     */
    public function adminUpdate(Request $request, $id)
    {
        $spmb = Spmb::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'status_pendaftaran' => 'required|in:Menunggu Verifikasi,Verifikasi Berhasil,Diterima,Ditolak,Cadangan',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.ppdb.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $spmb->update([
                'status_pendaftaran' => $request->status_pendaftaran,
                'catatan' => $request->catatan,
                'tanggal_verifikasi' => $request->status_pendaftaran != 'Menunggu Verifikasi' ? now() : $spmb->tanggal_verifikasi,
            ]);
            
            return redirect()->route('admin.ppdb.index')
                ->with('success', 'Data pendaftaran berhasil diperbarui');
                
        } catch (\Exception $e) {
            Log::error('Admin SPMB Update Error: ' . $e->getMessage());
            
            return redirect()->route('admin.ppdb.edit', $id)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Verifikasi dokumen SPMB
     */
    public function adminVerifikasiDokumen(Request $request, $id)
    {
        $spmb = Spmb::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'verifikasi_akte' => 'nullable|boolean',
            'verifikasi_kk' => 'nullable|boolean',
            'verifikasi_ktp' => 'nullable|boolean',
            'verifikasi_bukti_transfer' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.ppdb.show', $id)
                ->withErrors($validator);
        }

        try {
            $spmb->update([
                'verifikasi_akte' => $request->has('verifikasi_akte'),
                'verifikasi_kk' => $request->has('verifikasi_kk'),
                'verifikasi_ktp' => $request->has('verifikasi_ktp'),
                'verifikasi_bukti_transfer' => $request->has('verifikasi_bukti_transfer'),
            ]);
            
            // Update status jika semua dokumen terverifikasi
            if ($spmb->verifikasi_akte && $spmb->verifikasi_kk && $spmb->verifikasi_ktp) {
                if ($spmb->status_pendaftaran == 'Menunggu Verifikasi') {
                    $spmb->update(['status_pendaftaran' => 'Verifikasi Berhasil']);
                }
            }
            
            return redirect()->route('admin.ppdb.show', $id)
                ->with('success', 'Verifikasi dokumen berhasil diperbarui');
                
        } catch (\Exception $e) {
            Log::error('Admin Verifikasi Dokumen Error: ' . $e->getMessage());
            
            return redirect()->route('admin.ppdb.show', $id)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data SPMB
     */
    public function adminDestroy($id)
    {
        try {
            $spmb = Spmb::findOrFail($id);
            
            // Hapus dokumen terkait
            foreach ($spmb->dokumen as $dokumen) {
                \Storage::disk('public')->delete($dokumen->path_file);
                $dokumen->delete();
            }
            
            $spmb->delete();
            
            return redirect()->route('admin.ppdb.index')
                ->with('success', 'Data pendaftaran berhasil dihapus');
                
        } catch (\Exception $e) {
            Log::error('Admin SPMB Delete Error: ' . $e->getMessage());
            
            return redirect()->route('admin.ppdb.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export data SPMB ke Excel/PDF
     */
    public function adminExport(Request $request)
    {
        // Implementasi export sesuai kebutuhan
    }

    /**
     * PUBLIC SECTION (untuk pengguna umum)
     */
    
    /**
     * Halaman utama SPMB (Hub)
     */
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return view('Home.spmb.index', [
                'error' => 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.'
            ]);
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        return view('Home.spmb.index', compact('setting', 'now', 'tahunAjaranAktif'));
    }

    /**
     * Halaman formulir pendaftaran SPMB publik
     */
    public function pendaftaran()
    {
        if (!auth('siswa')->check()) {
            return redirect()->route('siswa.login')->with('error', 'Silakan login terlebih dahulu untuk mendaftar.');
        }

        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('spmb.index')
                ->with('error', 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.');
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        // Cek apakah pendaftaran dibuka
        if (!$this->isPendaftaranOpen($setting)) {
            return view('Home.spmb.pendaftaran-closed', compact('setting', 'now', 'tahunAjaranAktif'));
        }
        
        return view('Home.spmb.pendaftaran', compact('setting', 'now', 'tahunAjaranAktif'));
    }

    /**
     * Simpan data pendaftaran SPMB publik
     */
    public function store(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('spmb.pendaftaran')
                ->with('error', 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.')
                ->withInput();
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        // Validasi periode pendaftaran
        if (!$this->isPendaftaranOpen($setting)) {
            return redirect()->route('spmb.pendaftaran')
                ->with('error', 'Periode pendaftaran sudah ditutup.')
                ->withInput();
        }
        
        // Validasi data berdasarkan field di resources/views/Home/spmb/pendaftaran.blade.php
        $validator = Validator::make($request->all(), [
            // Section 1: Data Calon Siswa
            'nama_calon_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'nik' => 'required|string|max:20|unique:spmb,nik_anak',
            'alamat' => 'required|string',
            'akta_kelahiran' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'kartu_keluarga' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            
            // Section 2: Data Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|string|max:20',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|string|max:20',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_ortu' => 'required|string|max:20',
            'email_ortu' => 'nullable|email|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'hubungan_wali' => 'nullable|string|max:100',
            
            // Section 3: Jalur
            'jalur_pendaftaran' => 'required|string|max:100',
            'catatan_khusus' => 'nullable|string',
            
            // Hidden fields
            'jenis_daftar' => 'nullable|in:Siswa Baru,Pindahan',
            'punya_saudara_sekolah_tk' => 'nullable|in:Ya,Tidak',
        ], [
            'nik.max' => 'NIK anak maksimal 20 karakter',
            'nik.unique' => 'NIK ini sudah terdaftar',
            'nik_ayah.max' => 'NIK ayah maksimal 20 karakter',
            'nik_ibu.max' => 'NIK ibu maksimal 20 karakter',
            'akta_kelahiran.required' => 'Upload akta kelahiran',
            'kartu_keluarga.required' => 'Upload kartu keluarga',
        ]);

        if ($validator->fails()) {
            return redirect()->route('spmb.pendaftaran')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        
        try {
            // Validasi usia minimal 3 tahun
            $usia = Carbon::parse($request->tanggal_lahir)->age;
            if ($usia < 3) {
                return redirect()->route('spmb.pendaftaran')
                    ->with('error', 'Usia calon siswa minimal 3 tahun untuk mendaftar TK')
                    ->withInput();
            }
            
            // Map jenis kelamin L/P ke Laki-laki/Perempuan
            $jk = ($request->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan';
            
            // Generate nomor pendaftaran
            $noPendaftaran = $this->generateNomorPendaftaran();
            
            // Siapkan data untuk disimpan (sesuai Spmb model)
            $spmbData = [
                'no_pendaftaran' => $noPendaftaran,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'status_pendaftaran' => 'Menunggu Verifikasi',
                
                // Data Anak
                'nama_lengkap_anak' => $request->nama_calon_siswa,
                'nik_anak' => $request->nik,
                'tempat_lahir_anak' => $request->tempat_lahir,
                'tanggal_lahir_anak' => $request->tanggal_lahir,
                'jenis_kelamin' => $jk,
                'agama' => $request->agama,
                'nama_jalan_rumah' => $request->alamat,
                
                // Data Ayah
                'nama_lengkap_ayah' => $request->nama_ayah,
                'nik_ayah' => $request->nik_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'penghasilan_per_bulan_ayah' => $request->penghasilan_ayah,
                'nomor_telepon_ayah' => $request->no_hp_ortu,
                'email_ayah' => $request->email_ortu,
                
                // Data Ibu
                'nama_lengkap_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'nomor_telepon_ibu' => $request->no_hp_ortu,
                
                // Data Wali
                'punya_wali' => !empty($request->nama_wali),
                'nama_lengkap_wali' => $request->nama_wali,
                'hubungan_dengan_anak' => $request->hubungan_wali,
                
                // Informasi Tambahan
                'sumber_informasi_ppdb' => $request->jalur_pendaftaran,
                'punya_saudara_sekolah_tk' => $request->punya_saudara_sekolah_tk ?? 'Tidak',
                'jenis_daftar' => $request->jenis_daftar ?? 'Siswa Baru',
                'catatan_admin' => $request->catatan_khusus,
                
                // Status Verifikasi Dokumen (default false)
                'verifikasi_akte' => false,
                'verifikasi_kk' => false,
                'verifikasi_ktp' => false,
                'verifikasi_bukti_transfer' => false,
            ];
            
            // Buat record SPMB
            $spmb = Spmb::create($spmbData);
            
            // Upload dokumen
            $this->handleDokumenUploads($request, $spmb);
            
            DB::commit();

            NotificationController::notifyNewSpmbRegistration($spmb);
            
            // Redirect ke halaman success
            return redirect()->route('spmb.success', $noPendaftaran)
                ->with('success', 'Pendaftaran SPMB berhasil dikirim!')
                ->with('no_pendaftaran', $noPendaftaran);
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SPMB Store Error: ' . $e->getMessage());
            Log::error('SPMB Store Trace: ' . $e->getTraceAsString());
            
            return redirect()->route('spmb.pendaftaran')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Handle dokumen uploads
     */
    private function handleDokumenUploads(Request $request, Spmb $spmb)
    {
        $dokumenTypes = [
            'akte' => 'akta_kelahiran',
            'kk' => 'kartu_keluarga',
        ];
        
        foreach ($dokumenTypes as $jenis => $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('spmb/dokumen/' . $jenis . '/' . $spmb->id, 'public');
                
                SpmbDokumen::create([
                    'spmb_id' => $spmb->id,
                    'jenis_dokumen' => $jenis,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_file' => round($file->getSize() / 1024, 2), // dalam KB
                ]);
            }
        }
    }

    /**
     * Generate nomor pendaftaran
     */
    private function generateNomorPendaftaran()
    {
        $tahun = date('Y');
        $bulan = date('m');
        
        $lastData = Spmb::whereYear('created_at', $tahun)
                        ->orderBy('no_pendaftaran', 'desc')
                        ->first();
        
        if ($lastData) {
            // Extract nomor urut dari no_pendaftaran terakhir
            $lastNumber = intval(substr($lastData->no_pendaftaran, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return 'PPDB-' . $tahun . $bulan . '-' . $newNumber;
    }

    /**
     * Halaman sukses pendaftaran
     */
    public function success($noPendaftaran)
    {
        $spmb = Spmb::with(['tahunAjaran'])->where('no_pendaftaran', $noPendaftaran)->first();
        
        if (!$spmb) {
            return redirect()->route('spmb.index')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }
        
        return view('Home.spmb.success', compact('spmb'));
    }

    /**
     * Halaman pengumuman
     */
    public function pengumuman()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('spmb.index')
                ->with('error', 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.');
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        // LOGIC PENGUMUMAN
        $status = $this->getPengumumanStatus($setting, $now);
        
        return view('Home.spmb.pengumuman', compact('setting', 'now', 'status', 'tahunAjaranAktif'));
    }

    /**
     * Cek hasil pengumuman
     */
    public function cekPengumuman(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('spmb.pengumuman')
                ->with('error', 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.');
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        // Validasi apakah pengumuman dibuka dan sudah dipublish
        $status = $this->getPengumumanStatus($setting, $now);
        
        if ($status['status'] === 'sebelum') {
            return redirect()->route('spmb.pengumuman')
                ->with('error', 'Pengumuman belum dibuka. Akan dibuka pada ' . optional($setting)->pengumuman_mulai?->translatedFormat('d F Y, H:i'))
                ->withInput();
        }
        
        if ($status['status'] === 'countdown') {
            // Jika masih countdown, redirect ke halaman countdown
            return view('Home.spmb.countdown', compact('setting', 'now', 'status', 'tahunAjaranAktif'));
        }
        
        // Jika sudah lewat countdown, proses pencarian data
        // Validasi input
        $validator = Validator::make($request->all(), [
            'no_pendaftaran' => 'required|string',
            'nik_anak' => 'required|string|max:20'
        ], [
            'no_pendaftaran.required' => 'Masukkan nomor pendaftaran',
            'nik_anak.required' => 'Masukkan NIK calon siswa',
            'nik_anak.max' => 'NIK harus maksimal 20 karakter'
        ]);

        if ($validator->fails()) {
            return redirect()->route('spmb.pengumuman')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Cari data SPMB
        $spmb = Spmb::with(['tahunAjaran'])
            ->where('no_pendaftaran', $request->no_pendaftaran)
            ->where('nik_anak', $request->nik_anak)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();
        
        if (!$spmb) {
            return redirect()->route('spmb.pengumuman')
                ->with('error', 'Data tidak ditemukan. Periksa kembali No. Pendaftaran dan NIK.')
                ->withInput();
        }
        
        return view('Home.spmb.hasil-pengumuman', compact('spmb'));
    }

    /**
     * Halaman daftar peserta yang lulus (setelah countdown habis)
     */
    public function daftarPesertaLulus()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('spmb.index')
                ->with('error', 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.');
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        $status = $this->getPengumumanStatus($setting, $now);
        
        // Hanya tampilkan jika sudah lewat countdown
        if ($status['status'] !== 'selesai') {
            return redirect()->route('spmb.pengumuman')
                ->with('error', 'Pengumuman belum selesai.');
        }
        
        // Ambil data peserta yang lulus (status = Diterima)
        $pesertaLulus = Spmb::with(['tahunAjaran'])
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('status_pendaftaran', 'Diterima')
            ->orderBy('nama_lengkap_anak')
            ->get();
        
        return view('Home.spmb.daftar-lulus', compact('pesertaLulus', 'setting', 'tahunAjaranAktif'));
    }

    /**
     * Halaman countdown pengumuman
     */
    public function countdown()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->route('spmb.index')
                ->with('error', 'Tahun ajaran belum diaktifkan. Silakan hubungi administrator.');
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        $status = $this->getPengumumanStatus($setting, $now);
        
        if ($status['status'] !== 'countdown') {
            return redirect()->route('spmb.pengumuman');
        }
        
        return view('Home.spmb.countdown', compact('setting', 'now', 'status', 'tahunAjaranAktif'));
    }

    /**
     * API: Get status SPMB
     */
    public function getStatus(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return response()->json([
                'error' => 'Tahun ajaran tidak ditemukan'
            ], 404);
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        $status = [
            'pendaftaran_open' => $this->isPendaftaranOpen($setting),
            'pendaftaran_mulai' => optional($setting)->pendaftaran_mulai?->toIso8601String(),
            'pendaftaran_selesai' => optional($setting)->pendaftaran_selesai?->toIso8601String(),
            'pengumuman_mulai' => optional($setting)->pengumuman_mulai?->toIso8601String(),
            'pengumuman_selesai' => optional($setting)->pengumuman_selesai?->toIso8601String(),
            'is_published' => $setting ? $setting->is_published : false,
            'tahun_ajaran' => $tahunAjaranAktif->tahun_ajaran,
            'now' => $now->toIso8601String(),
        ];
        
        return response()->json($status);
    }

    /**
     * API: Get countdown
     */
    public function getCountdown(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return response()->json([
                'event' => 'none',
                'time_left' => null,
                'target_date' => null
            ]);
        }
        
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        $now = now();
        
        if (!$setting) {
            return response()->json([
                'event' => 'none',
                'time_left' => null,
                'target_date' => null
            ]);
        }
        
        // CEK NULL DENGAN OPTIONAL()
        $pendaftaranMulai = optional($setting)->pendaftaran_mulai;
        $pendaftaranSelesai = optional($setting)->pendaftaran_selesai;
        $pengumumanMulai = optional($setting)->pengumuman_mulai;
        $pengumumanSelesai = optional($setting)->pengumuman_selesai;
        
        // Tentukan countdown mana yang ditampilkan
        if ($pendaftaranMulai && $now < $pendaftaranMulai) {
            $targetDate = $pendaftaranMulai;
            $event = 'Pendaftaran Dibuka';
        } elseif ($pendaftaranMulai && $pendaftaranSelesai && $now >= $pendaftaranMulai && $now <= $pendaftaranSelesai) {
            $targetDate = $pendaftaranSelesai;
            $event = 'Pendaftaran Ditutup';
        } elseif ($pendaftaranSelesai && $pengumumanMulai && $now > $pendaftaranSelesai && $now < $pengumumanMulai) {
            $targetDate = $pengumumanMulai;
            $event = 'Pengumuman Dimulai';
        } elseif ($pengumumanMulai && $pengumumanSelesai && $now >= $pengumumanMulai && $now <= $pengumumanSelesai && !$setting->is_published) {
            $targetDate = $pengumumanMulai;
            $event = 'Menunggu Rilis';
        } else {
            return response()->json([
                'event' => 'Semua tahapan selesai',
                'time_left' => null,
                'target_date' => null
            ]);
        }
        
        $diff = $targetDate->diff($now);
        
        return response()->json([
            'event' => $event,
            'time_left' => [
                'days' => $diff->days,
                'hours' => $diff->h,
                'minutes' => $diff->i,
                'seconds' => $diff->s,
                'total_seconds' => $diff->days * 86400 + $diff->h * 3600 + $diff->i * 60 + $diff->s
            ],
            'target_date' => $targetDate->toIso8601String()
        ]);
    }

    /**
     * Cek apakah pendaftaran dibuka
     */
    private function isPendaftaranOpen($setting)
    {
        if (!$setting) return false;
        
        $now = now();
        return $now->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);
    }

    /**
     * Get pengumuman status
     */
    private function getPengumumanStatus($setting, $now)
    {
        if (!$setting || !$setting->is_published) {
            return [
                'status' => 'sebelum',
                'message' => 'Pengumuman belum dipublish',
                'target_date' => null,
                'time_left' => null
            ];
        }
        
        $pengumumanMulai = optional($setting)->pengumuman_mulai;
        $pengumumanSelesai = optional($setting)->pengumuman_selesai;
        
        if (!$pengumumanMulai || !$pengumumanSelesai) {
            return [
                'status' => 'sebelum',
                'message' => 'Jadwal pengumuman belum ditentukan',
                'target_date' => null,
                'time_left' => null
            ];
        }
        
        if ($now < $pengumumanMulai) {
            return [
                'status' => 'sebelum',
                'message' => 'Pengumuman akan dibuka pada ' . $pengumumanMulai->translatedFormat('d F Y, H:i'),
                'target_date' => $pengumumanMulai,
                'time_left' => $pengumumanMulai->diff($now)
            ];
        }
        
        $countdownEnd = $pengumumanMulai->copy()->addHours(1);
        
        if ($now >= $pengumumanMulai && $now < $countdownEnd) {
            return [
                'status' => 'countdown',
                'message' => 'Pengumuman akan ditampilkan dalam',
                'target_date' => $countdownEnd,
                'time_left' => $countdownEnd->diff($now)
            ];
        }
        
        return [
            'status' => 'selesai',
            'message' => 'Pengumuman sudah dibuka',
            'target_date' => null,
            'time_left' => null
        ];
    }

    // ======================= PEMBAGIAN KELAS =======================

    /**
     * Preview pembagian kelas
     */
    public function classDivisionPreview(Request $request)
    {
        try {
            $tahunAjaranId = $request->tahun_ajaran_id;
            
            if (!$tahunAjaranId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran tidak dipilih'
                ]);
            }
            
            // Ambil siswa yang sudah DITERIMA dan belum punya kelas
            $students = Spmb::where('status_pendaftaran', 'Diterima')
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->whereNull('kelas')
                ->orderBy('tanggal_lahir_anak', 'desc')
                ->get(['id', 'nama_lengkap_anak as nama', 'tanggal_lahir_anak', 'nik_anak as nik']);
            
            if ($students->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'students' => [],
                    'total' => 0,
                    'message' => 'Tidak ada siswa yang perlu dibagi'
                ]);
            }
            
            // Format data untuk preview
            $formattedStudents = $students->map(function($siswa) {
                $usia = Carbon::parse($siswa->tanggal_lahir_anak)->age;
                return [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'usia' => $usia . ' tahun',
                    'tanggal_lahir' => Carbon::parse($siswa->tanggal_lahir_anak)->format('d/m/Y'),
                    'nik' => $siswa->nik
                ];
            });
            
            return response()->json([
                'success' => true,
                'students' => $formattedStudents,
                'total' => $students->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Class division preview error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eksekusi pembagian kelas
     */
    public function executeClassDivision(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $tahunAjaranId = $request->tahun_ajaran_id;
            $kelompokAIds = $request->kelompok_a ?? [];
            $kelompokBIds = $request->kelompok_b ?? [];
            
            if (!$tahunAjaranId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran tidak dipilih'
                ]);
            }
            
            if (empty($kelompokAIds) && empty($kelompokBIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data untuk disimpan'
                ]);
            }
            
            // Update Kelompok A
            if (!empty($kelompokAIds)) {
                Spmb::whereIn('id', $kelompokAIds)
                    ->update([
                        'kelas' => 'Kelompok A',
                        'updated_at' => now()
                    ]);
            }
            
            // Update Kelompok B
            if (!empty($kelompokBIds)) {
                Spmb::whereIn('id', $kelompokBIds)
                    ->update([
                        'kelas' => 'Kelompok B',
                        'updated_at' => now()
                    ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pembagian kelas berhasil',
                'result' => [
                    'kelompok_a' => count($kelompokAIds),
                    'kelompok_b' => count($kelompokBIds),
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Execute class division error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
