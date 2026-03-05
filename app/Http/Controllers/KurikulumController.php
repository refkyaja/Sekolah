<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        $kurikulums = Kurikulum::all();
        
        $utama = $kurikulums->where('tipe', 'utama')->first();
        $pendekatan = $kurikulums->where('tipe', 'pendekatan')->first();
        $layanan = $kurikulums->where('tipe', 'layanan')->first();
        $status = $kurikulums->where('tipe', 'status')->first();
        $alasan = $kurikulums->where('tipe', 'alasan')->first();

        return view('Home.kurikulum.index', compact(
            'utama', 
            'pendekatan', 
            'layanan', 
            'status', 
            'alasan'
        ));
    }
}
