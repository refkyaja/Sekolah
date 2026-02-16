<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use Illuminate\Http\Request;

class BukuTamuController extends Controller
{
    public function index(Request $request)
    {
        $query = BukuTamu::latest();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }
        
        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }
        
        // Filter verified
        if ($request->filled('verified')) {
            $query->where('is_verified', $request->verified == 'yes');
        }
        
        $bukutamu = $query->paginate(20);
        
        $stats = [
            'total' => BukuTamu::count(),
            'today' => BukuTamu::today()->count(),
            'pending' => BukuTamu::where('status', 'pending')->count(),
            'verified' => BukuTamu::where('is_verified', true)->count(),
        ];
        
        return view('admin.bukutamu.index', compact('bukutamu', 'stats'));
    }

    public function show(BukuTamu $bukutamu)
    {
        return view('admin.bukutamu.show', compact('bukutamu'));
    }

    public function create()
    {
        return view('admin.bukutamu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'telepon' => 'nullable|string|max:20',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
            'tujuan_kunjungan' => 'required|string|max:500',
            'pesan_kesan' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,completed',
            'is_verified' => 'boolean'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_verified'] = $request->boolean('is_verified');

        BukuTamu::create($validated);

        return redirect()->route('admin.bukutamu.index')
            ->with('success', 'Data buku tamu berhasil ditambahkan!');
    }

    public function edit(BukuTamu $bukutamu)
    {
        return view('admin.bukutamu.edit', compact('bukutamu'));
    }

    public function update(Request $request, BukuTamu $bukutamu)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'instansi' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'telepon' => 'nullable|string|max:20',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
            'tujuan_kunjungan' => 'required|string|max:500',
            'pesan_kesan' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,completed',
            'is_verified' => 'boolean'
        ]);

        $validated['is_verified'] = $request->boolean('is_verified');
        $bukutamu->update($validated);

        return redirect()->route('admin.bukutamu.index')
            ->with('success', 'Data buku tamu berhasil diperbarui!');
    }

    public function destroy(BukuTamu $bukutamu)
    {
        $bukutamu->delete();

        return redirect()->route('admin.bukutamu.index')
            ->with('success', 'Data buku tamu berhasil dihapus!');
    }

    public function verify(BukuTamu $bukutamu)
    {
        $bukutamu->update(['is_verified' => true]);

        return back()->with('success', 'Data buku tamu berhasil diverifikasi!');
    }

    public function updateStatus(Request $request, BukuTamu $bukutamu)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $bukutamu->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function export(Request $request)
    {
        $query = BukuTamu::latest();
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->end_date);
        }
        
        $data = $query->get();
        
        // CSV Export logic here
        // Return Excel file
    }
}