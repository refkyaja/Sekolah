<?php

namespace App\Http\Controllers\Siswa\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\SpmbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HasilSeleksiController extends Controller
{
    public function __invoke(Request $request)
    {
        $siswa = auth('siswa')->user();
        $spmb = $siswa?->spmb;

        $settingQuery = SpmbSetting::query();

        if ($spmb?->tahun_ajaran_id) {
            $settingQuery->where('tahun_ajaran_id', $spmb->tahun_ajaran_id);
        } elseif ($siswa?->tahun_ajaran_id) {
            $settingQuery->where('tahun_ajaran_id', $siswa->tahun_ajaran_id);
        } elseif ($siswa?->tahun_ajaran) {
            $settingQuery->where('tahun_ajaran', $siswa->tahun_ajaran);
        }

        $setting = (clone $settingQuery)->latest('id')->first();

        return view('siswa.ppdb.hasil-seleksi', compact('siswa', 'spmb', 'setting'));
    }

    public function printBukti(Spmb $spmb)
    {
        $siswa = auth('siswa')->user();
        
        if ($spmb->siswa && $spmb->siswa->id != $siswa->id && $spmb->nik_anak != ($siswa->nik ?? '')) {
            abort(403, 'Unauthorized');
        }

        return view('siswa.ppdb.print', compact('spmb'));
    }

    public function uploadFoto(Request $request)
    {
        // Debug: log received data
        \Log::info('Upload foto request received', [
            'has_foto' => $request->hasFile('foto'),
            'foto_name' => $request->file('foto')?->getClientOriginalName(),
            'spmb_id' => $request->spmb_id,
            'siswa_id' => auth('siswa')->id() ?? null
        ]);

        $validator = \Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'spmb_id' => 'required|exists:spmb,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        $siswa = auth('siswa')->user();
        
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Unauthorized - Silakan login terlebih dahulu'], 403);
        }

        $spmb = Spmb::find($request->spmb_id);

        // Verify ownership
        if (!$spmb || ($spmb->siswa_id != $siswa->id && $spmb->nik_anak != ($siswa->nik ?? ''))) {
            return response()->json(['success' => false, 'message' => 'Unauthorized - Data tidak ditemukan'], 403);
        }

        try {
            // Delete old photo if exists
            if ($spmb->foto_calon_siswa) {
                Storage::disk('public')->delete($spmb->foto_calon_siswa);
            }

            // Store new photo
            $path = $request->file('foto')->store('foto-calon-siswa', 'public');
            
            $spmb->update(['foto_calon_siswa' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diupload',
                'foto_url' => asset('storage/' . $path)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
