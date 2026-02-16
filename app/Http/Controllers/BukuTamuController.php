<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuTamuController extends Controller
{
    public function index()
    {
        // Tampilkan form buku tamu di frontend
        return view('Home.buku-tamu.index');
    }

    public function store(Request $request)
{
    // 1. Rules dasar
    $rules = [
        'nama' => 'required|string|max:100',
        'instansi' => 'required|string|max:100',
        'jabatan' => 'nullable|string|max:100',
        'email' => 'nullable|email|max:100',
        'telepon' => 'nullable|string|max:20',
        'tanggal_kunjungan' => 'required|date|after_or_equal:today',
        'jam_kunjungan' => 'required|date_format:H:i',
        'tujuan_kunjungan' => 'required|string|max:500',
        'pesan_kesan' => 'nullable|string|max:1000',
    ];

    // 2. Captcha hanya aktif di production
    if (!app()->isLocal()) {
        $rules['g-recaptcha-response'] = 'required';
    }

    // 3. Validasi
    $validator = Validator::make($request->all(), $rules, [
        'nama.required' => 'Nama harus diisi',
        'instansi.required' => 'Instansi/Asal harus diisi',
        'tanggal_kunjungan.required' => 'Tanggal kunjungan harus diisi',
        'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh kurang dari hari ini',
        'jam_kunjungan.required' => 'Jam kunjungan harus diisi',
        'tujuan_kunjungan.required' => 'Tujuan kunjungan harus diisi',
        'g-recaptcha-response.required' => 'Captcha harus diisi',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    BukuTamu::create([
        'nama' => $request->nama,
        'instansi' => $request->instansi,
        'jabatan' => $request->jabatan,
        'email' => $request->email,
        'telepon' => $request->telepon,
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'jam_kunjungan' => $request->jam_kunjungan,
        'tujuan_kunjungan' => $request->tujuan_kunjungan,
        'pesan_kesan' => $request->pesan_kesan,
        'status' => 'pending',
        'is_verified' => false,
    ]);

    return redirect()->route('buku-tamu.success')
        ->with('success', 'Terima kasih! Data kunjungan Anda telah berhasil disimpan.');
    }


    public function success()
    {
        if (!session('success')) {
            return redirect()->route('buku-tamu.index');
        }
        
        return view('Home.buku-tamu.success');
    }
}