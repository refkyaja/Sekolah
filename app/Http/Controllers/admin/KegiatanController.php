<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::latest()->get();
        return view('admin.kegiatan.index', compact('kegiatan'));
    }
    
    public function create()
    {
        $kategori = ['Outdoor Activity', 'Art Performance', 'Academic', 'Sports', 'Culture', 'Other'];
        return view('admin.kegiatan.create', compact('kategori'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'kategori' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $kegiatan = new Kegiatan();
        $kegiatan->judul = $request->judul;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->tanggal = $request->tanggal;
        $kegiatan->kategori = $request->kategori;
        
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kegiatan', 'public');
            $kegiatan->foto = $path;
        }
        
        $kegiatan->save();
        
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kategori = ['Outdoor Activity', 'Art Performance', 'Academic', 'Sports', 'Culture', 'Other'];
        return view('admin.kegiatan.edit', compact('kegiatan', 'kategori'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'kategori' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->judul = $request->judul;
        $kegiatan->deskripsi = $request->deskripsi;
        $kegiatan->tanggal = $request->tanggal;
        $kegiatan->kategori = $request->kategori;
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($kegiatan->foto && Storage::disk('public')->exists($kegiatan->foto)) {
                Storage::disk('public')->delete($kegiatan->foto);
            }
            
            $path = $request->file('foto')->store('kegiatan', 'public');
            $kegiatan->foto = $path;
        }
        
        $kegiatan->save();
        
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        
        // Hapus foto jika ada
        if ($kegiatan->foto && Storage::disk('public')->exists($kegiatan->foto)) {
            Storage::disk('public')->delete($kegiatan->foto);
        }
        
        $kegiatan->delete();
        
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }
}