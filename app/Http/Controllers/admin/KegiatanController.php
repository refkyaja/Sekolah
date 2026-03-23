<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\AuthorizesModuleAccess;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    use AuthorizesModuleAccess;

    protected function kegiatanRoutePrefix(): string
    {
        return match (auth()->user()?->role) {
            'admin' => 'admin',
            'operator' => 'operator',
            'kepala_sekolah' => 'kepala-sekolah',
            'guru' => 'guru',
            default => 'admin',
        };
    }

    protected function kegiatanRoute(string $name, mixed ...$parameters): string
    {
        return route($this->kegiatanRoutePrefix() . '.kegiatan.' . $name, ...$parameters);
    }

    public function index()
    {
        $this->authorizeModule('kegiatan', 'read');

        return view('admin.kegiatan.index');
    }

    public function create()
    {
        $this->authorizeModule('kegiatan', 'create');

        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $this->authorizeModule('kegiatan', 'create');

        $validated = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'nullable',
            'waktu_selesai'   => 'nullable',
            'lokasi'          => 'required|string|max:255',
            'kategori'        => 'required|string|max:100',
            'deskripsi'       => 'nullable|string',
            'banner'          => 'nullable|image|max:5120',
            'is_published'    => 'boolean'
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner_path'] = $request->file('banner')->store('kegiatan', 'public');
        }

        Kegiatan::create($validated);

        return redirect()->to($this->kegiatanRoute('index'))
            ->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(Kegiatan $kegiatan)
    {
        $this->authorizeModule('kegiatan', 'read');

        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        $this->authorizeModule('kegiatan', 'update');

        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $this->authorizeModule('kegiatan', 'update');

        $validated = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'nullable',
            'waktu_selesai'   => 'nullable',
            'lokasi'          => 'required|string|max:255',
            'kategori'        => 'required|string|max:100',
            'deskripsi'       => 'nullable|string',
            'banner'          => 'nullable|image|max:5120',
            'is_published'    => 'boolean'
        ]);

        if ($request->hasFile('banner')) {
            // Hapus yang lama
            if ($kegiatan->banner_path) {
                Storage::disk('public')->delete($kegiatan->banner_path);
            }
            $validated['banner_path'] = $request->file('banner')->store('kegiatan', 'public');
        }

        $kegiatan->update($validated);

        return redirect()->to($this->kegiatanRoute('index'))
            ->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $this->authorizeModule('kegiatan', 'delete');

        $kegiatan->delete();

        return redirect()->to($this->kegiatanRoute('index'))
            ->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function togglePublish(Kegiatan $kegiatan)
    {
        $this->authorizeModule('kegiatan', 'update');

        $kegiatan->update(['is_published' => !$kegiatan->is_published]);

        return back()->with('success', 'Status kegiatan berhasil diubah!');
    }
}
