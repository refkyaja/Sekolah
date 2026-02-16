<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpmbSetting;
use App\Models\Spmb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpmbSettingController extends Controller
{
    /**
     * HALAMAN UTAMA SETTINGS - Pilih menu
     */
    public function index()
    {
        $tahunAjaran = '2026/2027'; // Bisa diambil dari session
        $setting = SpmbSetting::firstOrCreate(
            ['tahun_ajaran' => $tahunAjaran],
            [
                'gelombang' => 1,
                'status_pendaftaran' => 'draft',
                'status_pengumuman' => 'draft',
                'kuota_zonasi' => 50,
                'kuota_afirmasi' => 15,
                'kuota_prestasi' => 30,
                'kuota_mutasi' => 5,
            ]
        );
        
        return view('admin.spmb-settings.index', compact('setting', 'tahunAjaran'));
    }

    public function edit()
    {
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->first();
        
        if (!$setting) {
            $setting = new SpmbSetting();
            $setting->tahun_ajaran = '2026/2027';
            $setting->gelombang = 1;
            $setting->status_pendaftaran = 'draft';
            $setting->status_pengumuman = 'draft';
            $setting->is_published = false;
            $setting->kuota_zonasi = 50;
            $setting->kuota_afirmasi = 15;
            $setting->kuota_prestasi = 30;
            $setting->kuota_mutasi = 5;
            $setting->save();
        }
        
        // Get status pengumuman for display
        $statusPengumuman = $setting->getStatusPengumumanHomepage();
        
        // Get SPMB statistics
        $stats = Spmb::getStatistik();
        
        // Extract jalur-related statistics
        $jalur = [
            'zonasi' => $stats['zonasi'],
            'afirmasi' => $stats['afirmasi'],
            'prestasi' => $stats['prestasi'],
            'mutasi' => $stats['mutasi'],
        ];
        
        return view('admin.spmb-settings.index', compact('setting', 'statusPengumuman', 'stats', 'jalur'));
    }
    
    /**
     * FORM PENGATURAN PENDAFTARAN
     */
    public function pendaftaran()
    {
        $setting = SpmbSetting::where('tahun_ajaran', '2026/2027')->firstOrFail();
        
        // Ambil data siswa diterima (hanya NIK, Nama, Status)
        $siswaDiterima = Spmb::where('tahun_ajaran', '2026/2027')
                            ->where('status', 'diterima')
                            ->select('id', 'no_pendaftaran', 'nik', 'nama_calon_siswa', 'status')
                            ->orderBy('tanggal_verifikasi', 'desc')
                            ->paginate(10);
        
        // Total siswa diterima
        $totalDiterima = Spmb::where('tahun_ajaran', '2026/2027')
                            ->where('status', 'diterima')
                            ->count();
        
        // Total pendaftar
        $totalPendaftar = Spmb::where('tahun_ajaran', '2026/2027')->count();
        
        // Statistik per jalur
        $statistikJalur = Spmb::where('tahun_ajaran', '2026/2027')
                            ->where('status', 'diterima')
                            ->selectRaw('jalur_pendaftaran, count(*) as total')
                            ->groupBy('jalur_pendaftaran')
                            ->pluck('total', 'jalur_pendaftaran')
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
        
        return redirect()->route('admin.spmb-settings.index')
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
        
        // ============ DATA SISWA LULUS ============
        $siswaLulus = Spmb::where('tahun_ajaran', $tahunAjaran)
                        ->where('status', 'diterima')
                        ->select(
                            'id',
                            'no_pendaftaran',
                            'nik',
                            'nama_calon_siswa',
                            'jalur_pendaftaran',
                            'status'
                        )
                        ->orderBy('tanggal_verifikasi', 'desc')
                        ->paginate(10);
        
        // Total siswa lulus
        $totalLulus = Spmb::where('tahun_ajaran', $tahunAjaran)
                        ->where('status', 'diterima')
                        ->count();
        
        // Total pendaftar
        $totalPendaftar = Spmb::where('tahun_ajaran', $tahunAjaran)->count();
        
        // Statistik lulus per jalur
        $statistikJalur = Spmb::where('tahun_ajaran', $tahunAjaran)
                            ->where('status', 'diterima')
                            ->selectRaw('jalur_pendaftaran, count(*) as total')
                            ->groupBy('jalur_pendaftaran')
                            ->pluck('total', 'jalur_pendaftaran')
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
        
        return redirect()->route('admin.spmb-settings.index')
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
        
        return redirect()->route('admin.spmb-settings.index')
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