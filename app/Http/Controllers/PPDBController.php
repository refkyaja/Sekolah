<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PPDBController extends Controller
{
    public function index()
    {
        return view('ppdb.index', [
            'title' => 'Pendaftaran Peserta Didik Baru (PPDB)'
        ]);
    }

    public function store(Request $request)
    {
        // Ini nanti akan diisi dengan logic penyimpanan data
        return redirect()->route('ppdb.success');
    }

    public function success()
    {
        return view('ppdb.success', [
            'title' => 'Pendaftaran Berhasil'
        ]);
    }
}