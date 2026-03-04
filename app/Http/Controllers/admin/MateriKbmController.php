<?php
// app/Http/Controllers/Admin/MateriKbmController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MateriKbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MateriKbmController extends Controller
{
    /**
     * Display a listing of materi KBM.
     */
    public function index(Request $request)
    {
        $query = MateriKbm::latest('tanggal_publish');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_materi', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%");
            });
        }

        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', $request->mata_pelajaran);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $materiKbm       = $query->paginate(10)->withQueryString();
        $daftarMapel     = MateriKbm::daftarMataPelajaran();
        $daftarKelas     = MateriKbm::daftarKelas();

        return view('admin.materi-kbm.index', compact('materiKbm', 'daftarMapel', 'daftarKelas'));
    }

    /**
     * Show form to create a new materi KBM.
     */
    public function create()
    {
        $daftarMapel = MateriKbm::daftarMataPelajaran();
        $daftarKelas = MateriKbm::daftarKelas();

        return view('admin.materi-kbm.create', compact('daftarMapel', 'daftarKelas'));
    }

    /**
     * Store a newly created materi KBM.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran'  => 'required|string|max:100',
            'judul_materi'    => 'required|string|max:255',
            'kelas'           => 'required|string|max:20',
            'kelompok'        => 'nullable|string|max:50',
            'tanggal_publish' => 'required|date',
            'deskripsi'       => 'nullable|string',
            'file'            => 'nullable|file|max:51200', // max 50 MB
        ]);

        try {
            $data = [
                'mata_pelajaran'  => $request->mata_pelajaran,
                'judul_materi'    => $request->judul_materi,
                'kelas'           => $request->kelas,
                'kelompok'        => $request->kelompok,
                'tanggal_publish' => $request->tanggal_publish,
                'deskripsi'       => $request->deskripsi,
                'guru_id'         => auth()->user()->guru_id ?? null,
            ];

            if ($request->hasFile('file')) {
                $file            = $request->file('file');
                $path            = $file->store('materi-kbm', 'public');
                $data['file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_type'] = $this->resolveFileType($file->getClientOriginalExtension());
                $data['file_size'] = $file->getSize();
            }

            MateriKbm::create($data);

            return redirect()->route('admin.materi-kbm.index')
                ->with('success', 'Materi KBM berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating materi KBM: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan materi KBM.');
        }
    }

    /**
     * Display the specified materi KBM.
     */
    public function show(MateriKbm $materiKbm)
    {
        return view('admin.materi-kbm.show', compact('materiKbm'));
    }

    /**
     * Show form to edit materi KBM.
     */
    public function edit(MateriKbm $materiKbm)
    {
        $daftarMapel = MateriKbm::daftarMataPelajaran();
        $daftarKelas = MateriKbm::daftarKelas();

        return view('admin.materi-kbm.edit', compact('materiKbm', 'daftarMapel', 'daftarKelas'));
    }

    /**
     * Update the specified materi KBM.
     */
    public function update(Request $request, MateriKbm $materiKbm)
    {
        $request->validate([
            'mata_pelajaran'  => 'required|string|max:100',
            'judul_materi'    => 'required|string|max:255',
            'kelas'           => 'required|string|max:20',
            'kelompok'        => 'nullable|string|max:50',
            'tanggal_publish' => 'required|date',
            'deskripsi'       => 'nullable|string',
            'file'            => 'nullable|file|max:51200',
        ]);

        try {
            $data = [
                'mata_pelajaran'  => $request->mata_pelajaran,
                'judul_materi'    => $request->judul_materi,
                'kelas'           => $request->kelas,
                'kelompok'        => $request->kelompok,
                'tanggal_publish' => $request->tanggal_publish,
                'deskripsi'       => $request->deskripsi,
            ];

            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($materiKbm->file_path && Storage::disk('public')->exists($materiKbm->file_path)) {
                    Storage::disk('public')->delete($materiKbm->file_path);
                }

                $file              = $request->file('file');
                $path              = $file->store('materi-kbm', 'public');
                $data['file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_type'] = $this->resolveFileType($file->getClientOriginalExtension());
                $data['file_size'] = $file->getSize();
            }

            $materiKbm->update($data);

            return redirect()->route('admin.materi-kbm.index')
                ->with('success', 'Materi KBM berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating materi KBM: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui materi KBM.');
        }
    }

    /**
     * Remove the specified materi KBM.
     */
    public function destroy(MateriKbm $materiKbm)
    {
        try {
            if ($materiKbm->file_path && Storage::disk('public')->exists($materiKbm->file_path)) {
                Storage::disk('public')->delete($materiKbm->file_path);
            }

            $materiKbm->delete();

            return redirect()->route('admin.materi-kbm.index')
                ->with('success', 'Materi KBM berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting materi KBM: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus materi KBM.');
        }
    }

    /**
     * Download the file of a materi KBM.
     */
    public function download(MateriKbm $materiKbm)
    {
        if (!$materiKbm->file_path || !Storage::disk('public')->exists($materiKbm->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $materiKbm->file_path,
            $materiKbm->file_name ?? 'materi-kbm'
        );
    }

    /**
     * Resolve a human-readable file type from extension.
     */
    private function resolveFileType(string $extension): string
    {
        return match (strtolower($extension)) {
            'pdf'                   => 'PDF Document',
            'ppt', 'pptx'          => 'PowerPoint',
            'doc', 'docx'          => 'Word Document',
            'xls', 'xlsx'          => 'Excel Spreadsheet',
            'mp4', 'avi', 'mov'    => 'Video',
            'jpg', 'jpeg', 'png'   => 'Gambar',
            'zip', 'rar'           => 'Archive',
            default                => strtoupper($extension) . ' File',
        };
    }
}
