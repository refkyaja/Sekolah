<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpmbSetting;
use App\Models\Spmb;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpmbSettingController extends Controller
{
    /**
     * HALAMAN UTAMA SETTINGS - Pilih menu
     */
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $setting = SpmbSetting::firstOrCreate(
            ['tahun_ajaran_id' => $tahunAjaranAktif->id],
            [
                'tahun_ajaran' => $tahunAjaranAktif->tahun_ajaran,
                'gelombang' => 1,
                'status_pendaftaran' => 'draft',
                'status_pengumuman' => 'draft',
                'kuota_zonasi' => 50,
                'kuota_afirmasi' => 15,
                'kuota_prestasi' => 30,
                'kuota_mutasi' => 5,
            ]
        );
        
        return view('admin.spmb-settings.index', compact('setting'));
    }

    public function edit()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        
        if (!$setting) {
            $setting = SpmbSetting::create([
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'tahun_ajaran' => $tahunAjaranAktif->tahun_ajaran,
                'gelombang' => 1,
                'status_pendaftaran' => 'draft',
                'status_pengumuman' => 'draft',
                'is_published' => false,
                'kuota_zonasi' => 50,
                'kuota_afirmasi' => 15,
                'kuota_prestasi' => 30,
                'kuota_mutasi' => 5,
            ]);
        }
        
        // Get status pengumuman for display
        $statusPengumuman = $setting->getStatusPengumumanHomepage();

        // Get SPMB statistics
        $stats = Spmb::getStatistik($tahunAjaranAktif->id);

        return view('admin.spmb-settings.index', compact('setting', 'statusPengumuman', 'stats'));

    }
    
    /**
     * FORM PENGATURAN PENDAFTARAN
     */
    public function pendaftaran()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        
        // Ambil data siswa diterima (hanya NIK, Nama, Status)
        $siswaDiterima = Spmb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                            ->where('status_pendaftaran', 'Diterima')
                            ->select('id', 'no_pendaftaran', 'nik_anak', 'nama_lengkap_anak', 'status_pendaftaran')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        
        // Total siswa diterima
        $totalDiterima = Spmb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                            ->where('status_pendaftaran', 'Diterima')
                            ->count();
        
        // Total pendaftar
        $totalPendaftar = Spmb::where('tahun_ajaran_id', $tahunAjaranAktif->id)->count();
        
        $statistikJalur = [];

        return view('admin.spmb-settings.pendaftaran', compact(
            'setting',
            'siswaDiterima',
            'totalDiterima',
            'totalPendaftar',
            'statistikJalur'
        ));
    }
    
    /**
     * UPDATE PENGATURAN PENDAFTARAN
     */
    public function updatePendaftaran(Request $request)
    {
        $request->validate([
            'pendaftaran_mulai' => 'required|date',
            'pendaftaran_selesai' => 'required|date|after:pendaftaran_mulai',
            'kuota_zonasi' => 'required|integer|min:0|max:100',
            'kuota_afirmasi' => 'required|integer|min:0|max:100',
            'kuota_prestasi' => 'required|integer|min:0|max:100',
            'kuota_mutasi' => 'required|integer|min:0|max:100',
        ]);
        
        // Validasi total kuota
        $total = $request->kuota_zonasi + $request->kuota_afirmasi + 
                 $request->kuota_prestasi + $request->kuota_mutasi;
        
        if ($total > 100) {
            return redirect()->back()
                ->withErrors(['kuota' => 'Total kuota tidak boleh melebihi 100%'])
                ->withInput();
        }
        
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        
        $setting->pendaftaran_mulai = $request->pendaftaran_mulai;
        $setting->pendaftaran_selesai = $request->pendaftaran_selesai;
        $setting->status_pendaftaran = $request->status_pendaftaran;
        $setting->kuota_zonasi = $request->kuota_zonasi;
        $setting->kuota_afirmasi = $request->kuota_afirmasi;
        $setting->kuota_prestasi = $request->kuota_prestasi;
        $setting->kuota_mutasi = $request->kuota_mutasi;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.spmb-settings.index')
            ->with('success', 'Pengaturan pendaftaran berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN PENGUMUMAN
     */
    public function pengumuman()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaran = $tahunAjaranAktif->tahun_ajaran;
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();

        
        // ============ DATA SISWA LULUS ============
        $siswaLulus = Spmb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->where('status_pendaftaran', 'Diterima')
                        ->select(
                            'id',
                            'no_pendaftaran',
                            'nik_anak',
                            'nama_lengkap_anak',
                            'jenis_daftar',
                            'status_pendaftaran'
                        )
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        // Total siswa lulus
        $totalLulus = Spmb::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->where('status_pendaftaran', 'Diterima')
                        ->count();
        
        // Total pendaftar
        $totalPendaftar = Spmb::where('tahun_ajaran_id', $tahunAjaranAktif->id)->count();
        
        $statistikJalur = [];

        return view('admin.spmb-settings.pengumuman', compact(
            'setting',
            'siswaLulus',
            'totalLulus',
            'totalPendaftar',
            'statistikJalur'
        ));
    }
    
    /**
     * UPDATE PENGATURAN PENGUMUMAN
     */
    public function updatePengumuman(Request $request)
    {
        $request->validate([
            'pengumuman_mulai' => 'required|date',
            'pengumuman_selesai' => 'required|date|after:pengumuman_mulai',
            'status_pengumuman' => 'required|in:draft,ready,published,closed',
        ]);
        
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        
        $setting->pengumuman_mulai = $request->pengumuman_mulai;
        $setting->pengumuman_selesai = $request->pengumuman_selesai;
        $setting->status_pengumuman = $request->status_pengumuman;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.spmb-settings.index')
            ->with('success', 'Pengaturan pengumuman berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN SISTEM
     */
    public function sistem()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        return view('admin.spmb-settings.sistem', compact('setting'));
    }
    
    /**
     * UPDATE PENGATURAN SISTEM
     */
    public function updateSistem(Request $request)
    {
        $request->validate([
            'pesan_tunggu' => 'nullable|string',
            'pesan_selesai' => 'nullable|string',
        ]);
        
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        
        $setting->pesan_tunggu = $request->pesan_tunggu;
        $setting->pesan_selesai = $request->pesan_selesai;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.spmb-settings.index')
            ->with('success', 'Pengaturan sistem berhasil disimpan!');
    }
    
    /**
     * PUBLISH PENGUMUMAN (AKSI CEPAT)
     */
    public function publish()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        
        $setting->status_pengumuman = 'published';
        $setting->save();
        
        return redirect()->back()
            ->with('success', 'Pengumuman berhasil ditampilkan!');
    }
    
    /**
     * UNPUBLISH PENGUMUMAN (AKSI CEPAT)
     */
    public function unpublish()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();
        
        $setting->status_pengumuman = 'draft';
        $setting->save();
        
        return redirect()->back()
            ->with('success', 'Pengumuman berhasil disembunyikan!');
    }
}