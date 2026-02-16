<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\SpmbBuktiTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SpmbBuktiTransferController extends Controller
{
    /**
     * Display listing of payment proofs
     */
    public function index(Request $request)
    {
        $query = SpmbBuktiTransfer::with(['spmb', 'verifikator']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Search by name or bank
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_pengirim', 'like', '%' . $request->search . '%')
                  ->orWhere('bank_pengirim', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_rekening_pengirim', 'like', '%' . $request->search . '%');
            });
        }

        $buktiTransfers = $query->latest()->paginate(15);

        // Statistik
        $statistik = [
            'total' => SpmbBuktiTransfer::count(),
            'menunggu' => SpmbBuktiTransfer::menunggu()->count(),
            'terverifikasi' => SpmbBuktiTransfer::terverifikasi()->count(),
            'ditolak' => SpmbBuktiTransfer::ditolak()->count(),
        ];

        return view('admin.spmb.bukti-transfer.index', compact('buktiTransfers', 'statistik'));
    }

    /**
     * Upload payment proof
     */
    public function store(Request $request, Spmb $spmb)
    {
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'bank_pengirim' => 'required|string|max:100',
            'nomor_rekening_pengirim' => 'required|string|max:50',
            'jumlah_transfer' => 'required|numeric|min:0',
            'tanggal_transfer' => 'required|date',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('spmb/bukti-transfer', 'public');

            $buktiTransfer = $spmb->buktiTransfer()->create([
                'nama_pengirim' => $request->nama_pengirim,
                'bank_pengirim' => $request->bank_pengirim,
                'nomor_rekening_pengirim' => $request->nomor_rekening_pengirim,
                'jumlah_transfer' => $request->jumlah_transfer,
                'tanggal_transfer' => $request->tanggal_transfer,
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'status_verifikasi' => 'Menunggu',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti transfer berhasil diupload',
                'data' => $buktiTransfer
            ]);

        } catch (\Exception $e) {
            Log::error('Upload bukti transfer error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload bukti transfer: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show verification form
     */
    public function show(SpmbBuktiTransfer $buktiTransfer)
    {
        $buktiTransfer->load(['spmb', 'verifikator']);
        
        return view('admin.spmb.bukti-transfer.show', compact('buktiTransfer'));
    }

    /**
     * Verify payment proof
     */
    public function verifikasi(Request $request, SpmbBuktiTransfer $buktiTransfer)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            $buktiTransfer->verifikasi(auth()->id(), $request->catatan);

            return response()->json([
                'success' => true,
                'message' => 'Bukti transfer berhasil diverifikasi'
            ]);

        } catch (\Exception $e) {
            Log::error('Verifikasi bukti transfer error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal verifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject payment proof
     */
    public function tolak(Request $request, SpmbBuktiTransfer $buktiTransfer)
    {
        $request->validate([
            'catatan' => 'required|string|max:500',
        ]);

        try {
            $buktiTransfer->tolak(auth()->id(), $request->catatan);

            return response()->json([
                'success' => true,
                'message' => 'Bukti transfer ditolak'
            ]);

        } catch (\Exception $e) {
            Log::error('Tolak bukti transfer error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download payment proof
     */
    public function download(SpmbBuktiTransfer $buktiTransfer)
    {
        if (!Storage::disk('public')->exists($buktiTransfer->path_file)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($buktiTransfer->path_file, $buktiTransfer->nama_file);
    }

    /**
     * Delete payment proof
     */
    public function destroy(SpmbBuktiTransfer $buktiTransfer)
    {
        try {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($buktiTransfer->path_file)) {
                Storage::disk('public')->delete($buktiTransfer->path_file);
            }

            $buktiTransfer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bukti transfer berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Hapus bukti transfer error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal hapus bukti transfer: ' . $e->getMessage()
            ], 500);
        }
    }
}