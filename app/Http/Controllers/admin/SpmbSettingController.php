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
     * FORM PENGATURAN PENDAFTARAN
     */
    public function pendaftaran()
    {
        return redirect()->route('admin.ppdb.pengaturan');
    }
    
    /**
     * UPDATE PENGATURAN PENDAFTARAN
     */
    public function updatePendaftaran(Request $request)
    {
        $request->validate([
            'pendaftaran_mulai' => 'required|date',
            'pendaftaran_selesai' => 'required|date|after:pendaftaran_mulai',
        ]);

        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->firstOrFail();

        $setting->pendaftaran_mulai = $request->pendaftaran_mulai;
        $setting->pendaftaran_selesai = $request->pendaftaran_selesai;
        $setting->status_pendaftaran = $request->status_pendaftaran;
        $setting->updated_by = Auth::id();
        $setting->save();
        
        return redirect()->route('admin.ppdb.pengaturan')
            ->with('success', 'Pengaturan pendaftaran berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN PENGUMUMAN
     */
    public function pengumuman()
    {
        return redirect()->route('admin.ppdb.pengaturan');
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
        
        return redirect()->route('admin.ppdb.pengaturan')
            ->with('success', 'Pengaturan pengumuman berhasil disimpan!');
    }
    
    /**
     * FORM PENGATURAN SISTEM
     */
    public function sistem()
    {
        return redirect()->route('admin.ppdb.pengaturan');
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
        
        return redirect()->route('admin.ppdb.pengaturan')
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