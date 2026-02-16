<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita
     */
    public function index()
    {
        $beritas = Berita::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,publish',
            'tanggal_publish' => 'required|date',
            'penulis' => 'required|string|max:100'
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('berita', 'public');
            $validated['gambar'] = $imagePath;
        }

        // Tambah data otomatis
        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($request->judul);

        // Simpan berita
        Berita::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail berita
     */
    public function show(Berita $berita)
    {
        return view('admin.berita.show', ['berita' => $berita]);
    }

    /**
     * Menampilkan form edit berita
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', [
            'berita' => $berita
        ]);
    }

    /**
     * Update berita
     */
    public function update(Request $request, Berita $berita)
    {
        // Validasi
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:100',
            'isi_berita' => 'required|string',
            'status' => 'required|in:draft,publish',
            'tanggal_publish' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        try {
            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($berita->gambar) {
                    Storage::disk('public')->delete($berita->gambar);
                }
                
                // Upload gambar baru
                $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
            } else {
                // Pertahankan gambar lama jika tidak ada upload baru
                $validated['gambar'] = $berita->gambar;
            }

            // Update slug jika judul berubah
            if ($berita->judul !== $validated['judul']) {
                $validated['slug'] = Str::slug($validated['judul']);
            }

            // Update data
            $berita->update($validated);
            
            return redirect()->route('admin.berita.index')
                ->with('success', 'Berita berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate berita: ' . $e->getMessage());
        }
    }

    /**
     * Hapus berita
     */
    public function destroy(Berita $berita)
    {
        // Hapus gambar jika ada
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Publish berita
     */
    public function publish(Berita $berita)
    {
        $berita->update(['status' => 'publish']);
        
        return redirect()->route('admin.berita.show', $berita->id)
            ->with('success', 'Berita berhasil dipublish!');
    }
    
    /**
     * Unpublish berita
     */
    public function unpublish(Berita $berita)
    {
        $berita->update(['status' => 'draft']);
        
        return redirect()->route('admin.berita.show', $berita)
            ->with('success', 'Berita berhasil diunpublish!');
    }
}