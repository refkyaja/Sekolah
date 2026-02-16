<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\SpmbDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SpmbDokumenController extends Controller
{
    /**
     * Display listing of documents for a SPMB
     */
    public function index(Spmb $spmb)
    {
        $dokumen = $spmb->dokumen()->latest()->get();
        
        return view('admin.spmb.dokumen.index', compact('spmb', 'dokumen'));
    }

    /**
     * Upload new document
     */
    public function store(Request $request, Spmb $spmb)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:akte,kk,ktp,bukti_transfer,sertifikat_prestasi,surat_mutasi,kartu_bantuan',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('spmb/dokumen/' . $request->jenis_dokumen, 'public');

            $dokumen = $spmb->dokumen()->create([
                'jenis_dokumen' => $request->jenis_dokumen,
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'mime_type' => $file->getMimeType(),
                'ukuran_file' => round($file->getSize() / 1024, 2),
                'keterangan' => $request->keterangan,
                'uploaded_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload',
                'data' => $dokumen
            ]);

        } catch (\Exception $e) {
            Log::error('Upload dokumen error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download document
     */
    public function download(SpmbDokumen $dokumen)
    {
        if (!Storage::disk('public')->exists($dokumen->path_file)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($dokumen->path_file, $dokumen->nama_file);
    }

    /**
     * Delete document
     */
    public function destroy(SpmbDokumen $dokumen)
    {
        try {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($dokumen->path_file)) {
                Storage::disk('public')->delete($dokumen->path_file);
            }

            $dokumen->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Hapus dokumen error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal hapus dokumen: ' . $e->getMessage()
            ], 500);
        }
    }
}