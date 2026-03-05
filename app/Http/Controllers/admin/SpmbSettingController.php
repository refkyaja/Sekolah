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
     * HALAMAN UTAMA SETTINGS - Redirect to ppdb pengaturan
     */
    public function index()
    {
        return redirect()->route('admin.ppdb.pengaturan');
    }

    public function edit()
    {
        return redirect()->route('admin.ppdb.pengaturan');
    }

    /**
     * Update Pengaturan
     */
    public function update(Request $request)
    {
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
        $setting->pendaftaran_mulai = $request->pendaftaran_mulai;
        $setting->pendaftaran_selesai = $request->pendaftaran_selesai;
        $setting->pengumuman_mulai = $request->pengumuman_mulai;
        $setting->save();
        
        return redirect()->route('admin.ppdb.pengaturan')->with('success', 'Pengaturan berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN PENDAFTARAN
     */
    public function pendaftaran()
    {
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        $ta = TahunAjaran::where('tahun_ajaran', $setting->tahun_ajaran)->first();
        $tahunAjaranId = $ta?->id;
        
        // Ambil data pendaftaran yang lulus
        $siswaDiterima = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                            ->where('status_pendaftaran', 'Lulus')
                            ->select('id', 'no_pendaftaran', 'nik_anak', 'nama_lengkap_anak', 'status_pendaftaran')
                            ->latest()
                            ->paginate(10);
        
        // Total siswa diterima
        $totalDiterima = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                            ->where('status_pendaftaran', 'Lulus')
                            ->count();
        
        // Total pendaftar
        $totalPendaftar = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count();
        
        // Statistik per jalur
        $statistikJalur = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                            ->where('status_pendaftaran', 'Lulus')
                            ->selectRaw('jenis_daftar, count(*) as total')
                            ->groupBy('jenis_daftar')
                            ->pluck('total', 'jenis_daftar')
                            ->toArray();
        
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
        
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
        $setting->pendaftaran_mulai = $request->pendaftaran_mulai;
        $setting->pendaftaran_selesai = $request->pendaftaran_selesai;
        $setting->status_pendaftaran = $request->status_pendaftaran;
        $setting->kuota_zonasi = $request->kuota_zonasi;
        $setting->kuota_afirmasi = $request->kuota_afirmasi;
        $setting->kuota_prestasi = $request->kuota_prestasi;
        $setting->kuota_mutasi = $request->kuota_mutasi;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.ppdb.pengaturan')
            ->with('success', 'Pengaturan pendaftaran berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN PENGUMUMAN
     */
    // app/Http/Controllers/Admin/SpmbSettingController.php

    public function pengumuman()
    {
        $tahunAjaran = '2026/2027';
        $setting = SpmbSetting::where('tahun_ajaran', $tahunAjaran)->firstOrFail();
        $ta = TahunAjaran::where('tahun_ajaran', $tahunAjaran)->first();
        $tahunAjaranId = $ta?->id;
        
        // ============ DATA SISWA LULUS ============
        $siswaLulus = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                        ->where('status_pendaftaran', 'Lulus')
                        ->select(
                            'id',
                            'no_pendaftaran',
                            'nik_anak',
                            'nama_lengkap_anak',
                            'jenis_daftar',
                            'status_pendaftaran'
                        )
                        ->latest()
                        ->paginate(10);
        
        // Total siswa lulus
        $totalLulus = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                        ->where('status_pendaftaran', 'Lulus')
                        ->count();
        
        // Total pendaftar
        $totalPendaftar = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count();
        
        // Statistik lulus per jalur
        $statistikJalur = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                            ->where('status_pendaftaran', 'Lulus')
                            ->selectRaw('jenis_daftar, count(*) as total')
                            ->groupBy('jenis_daftar')
                            ->pluck('total', 'jenis_daftar')
                            ->toArray();
        
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
        
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
        $setting->pengumuman_mulai = $request->pengumuman_mulai;
        $setting->pengumuman_selesai = $request->pengumuman_selesai;
        $setting->status_pengumuman = $request->status_pengumuman;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.ppdb.pengaturan')
            ->with('success', 'Pengaturan pengumuman berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN SISTEM
     */
    public function sistem()
    {
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
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
        
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
        $setting->pesan_tunggu = $request->pesan_tunggu;
        $setting->pesan_selesai = $request->pesan_selesai;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.ppdb.pengaturan')
            ->with('success', 'Pengaturan sistem berhasil disimpan!');
    }
    
    /**
     * PUBLISH PENGUMUMAN (AKSI CEPAT)
     */
    public function publish()
    {
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
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
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
        $setting->status_pengumuman = 'draft';
        $setting->save();
        
        return redirect()->back()
            ->with('success', 'Pengumuman berhasil disembunyikan!');
    }
}