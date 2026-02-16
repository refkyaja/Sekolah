<?php
// app/Http/Controllers/Admin/TahunAjaranController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of tahun ajaran.
     */
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')
                        ->orderBy('semester', 'desc')
                        ->paginate(10);
        
        return view('admin.tahun-ajaran.index', compact('tahunAjaran'));
    }

    /**
     * Show form create tahun ajaran.
     */
    public function create()
    {
        return view('admin.tahun-ajaran.create');
    }

    /**
     * Store new tahun ajaran.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9|unique:tahun_ajarans,tahun_ajaran',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ]);

        try {
            // Jika ingin mengaktifkan, nonaktifkan yang lain dulu
            if ($request->is_aktif) {
                TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
            }

            TahunAjaran::create([
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'is_aktif' => $request->is_aktif ?? false,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('admin.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating tahun ajaran: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Gagal menambahkan tahun ajaran.');
        }
    }

    /**
     * Show form edit tahun ajaran.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Update tahun ajaran.
     */
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9|unique:tahun_ajarans,tahun_ajaran,' . $tahunAjaran->id,
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keterangan' => 'nullable|string',
        ]);

        try {
            // Jika mengaktifkan, nonaktifkan yang lain
            if ($request->is_aktif && !$tahunAjaran->is_aktif) {
                TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
            }

            $tahunAjaran->update([
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'is_aktif' => $request->is_aktif ?? false,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('admin.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating tahun ajaran: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Gagal memperbarui tahun ajaran.');
        }
    }

    /**
     * Set tahun ajaran aktif.
     */
    public function setActive(TahunAjaran $tahunAjaran)
    {
        try {
            TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
            $tahunAjaran->update(['is_aktif' => true]);

            return redirect()->route('admin.tahun-ajaran.index')
                ->with('success', "Tahun ajaran {$tahunAjaran->tahun_ajaran} diaktifkan.");
        } catch (\Exception $e) {
            Log::error('Error setting active tahun ajaran: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengaktifkan tahun ajaran.');
        }
    }

    /**
     * Delete tahun ajaran.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        // Cek apakah ada relasi dengan data lain
        if ($tahunAjaran->spmb()->exists()) {
            return back()->with('error', 'Tahun ajaran tidak dapat dihapus karena masih memiliki data SPMB.');
        }

        if ($tahunAjaran->is_aktif) {
            return back()->with('error', 'Tahun ajaran aktif tidak dapat dihapus.');
        }

        try {
            $tahunAjaran->delete();
            return redirect()->route('admin.tahun-ajaran.index')
                ->with('success', 'Tahun ajaran berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting tahun ajaran: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus tahun ajaran.');
        }
    }
}