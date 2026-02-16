<?php
// app/Http/Controllers/Admin/GuruController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/Admin/GuruController.php

public function index(Request $request)
{
    try {
        // Gunakan query builder dengan select spesifik
        $query = Guru::query()
            ->select([
                'id', 'nip', 'nama', 'tempat_lahir', 'tanggal_lahir', 
                'jenis_kelamin', 'alamat', 'no_hp', 'email', 'jabatan', 
                'kelompok', 'pendidikan_terakhir', 'foto'
            ]);
        
        $search = $request->get('search', '');
        
        // Gunakan index untuk pencarian (pastikan ada index di database)
        if (!empty($search)) {
            // Hanya cari di field yang sering digunakan dan punya index
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "{$search}%") // Gunakan prefix search
                  ->orWhere('nip', '=', $search) // Exact match untuk NIP
                  ->orWhere('email', 'LIKE', "{$search}%");
            });
        }
        
        // Filter dengan where sederhana
        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }
        
        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }
        
        // Pagination dengan jumlah yang wajar
        $perPage = $request->get('per_page', 15); // Kurangi dari 10 ke 15 default
        $gurus = $query->orderBy('nama', 'asc')->paginate($perPage);
        
        // Untuk AJAX, kirim data minimal
        if ($request->has('ajax')) {
            return response()->json([
                'success' => true,
                'table_html' => view('admin.guru.partials.table', compact('gurus', 'search'))->render(),
                'pagination_html' => $gurus->hasPages() ? 
                    $gurus->onEachSide(1)->links('vendor.pagination.tailwind')->toHtml() : '',
                'stats_html' => view('admin.guru.partials.stats', compact('gurus'))->render(),
                'total' => $gurus->total(),
                'filtered_count' => $gurus->count(),
            ]);
        }
        
        return view('admin.guru.index', compact('gurus', 'search'));
        
    } catch (\Exception $e) {
        \Log::error('GuruController Error: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data.'
            ], 500);
        }
        
        return redirect()->route('admin.guru.index')
            ->with('error', 'Terjadi kesalahan saat memuat data.');
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak perlu passing data ke view karena sudah sederhana
        return view('admin.guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'nullable|unique:gurus,nip|max:20',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|unique:gurus,email',
            'jabatan' => 'required|in:guru,staff',
            'kelompok' => 'nullable|in:A,B',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        // Jika jabatan bukan guru, hapus nilai kelompok
        if ($request->jabatan !== 'guru') {
            $validated['kelompok'] = null;
        }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        }

        Guru::create($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        // Tidak perlu passing data tambahan ke view
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nip' => 'nullable|max:20|unique:gurus,nip,' . $guru->id,
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|unique:gurus,email,' . $guru->id,
            'jabatan' => 'required|in:guru,staff',
            'kelompok' => 'nullable|in:A,B',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        // Jika jabatan bukan guru, hapus nilai kelompok
        if ($request->jabatan !== 'guru') {
            $validated['kelompok'] = null;
        }

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        try {
            // Hapus foto jika ada
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            $guru->delete();

            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil dihapus.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Gagal menghapus data guru.');
        }
    }
}