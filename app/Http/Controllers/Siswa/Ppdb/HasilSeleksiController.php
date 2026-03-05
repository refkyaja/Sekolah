<?php

namespace App\Http\Controllers\Siswa\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\SpmbSetting;
use Illuminate\Http\Request;

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
}
