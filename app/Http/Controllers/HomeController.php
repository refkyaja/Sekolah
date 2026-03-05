<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Program;
use App\Models\Testimoni;
use App\Models\BukuTamu;
use App\Models\Spmb;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil berita terbaru untuk ditampilkan di homepage (max 3)
        $beritas = Berita::where('status', 'publish')
                        ->where('tanggal_publish', '<=', now())
                        ->orderBy('tanggal_publish', 'desc')
                        ->take(3)
                        ->get();
        
        // Ambil data galeri
        $galeris = Galeri::where('is_published', 1)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();

        $programs = Program::all();
        $testimonis = Testimoni::latest()->take(4)->get();

        // Data guru (tetap array)
        $guru = [
            [
                'nama' => 'Siti Nurhaliza, S.Pd',
                'jabatan' => 'Kepala Sekolah',
                'deskripsi' => 'S1 Pendidikan Anak Usia Dini, 15 tahun pengalaman',
                'foto' => 'images/kepala-sekolah.jpg'
            ],
            // ... data guru lainnya
        ];

        return view('home', compact('beritas', 'galeris', 'guru', 'programs', 'testimonis'));
    }

    public function storeBukuTamu(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'status' => 'required|string|in:parent,alumni,visitor',
            'pesan_kesan' => 'required|string|max:1000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('bukutamu-section');
        }

        BukuTamu::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'instansi' => $request->status, // Map status to instansi temporarily as requested by db
            'jabatan' => $request->status,
            'tanggal_kunjungan' => now()->toDateString(),
            'jam_kunjungan' => now()->toTimeString(),
            'tujuan_kunjungan' => 'Homepage Guestbook',
            'pesan_kesan' => $request->pesan_kesan,
            'status' => 'pending',
            'is_verified' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Terima kasih atas pesan dan kesan Anda!')
            ->withFragment('bukutamu-section');
    }

    public function ppdb()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();

        return view('home.ppdb', compact('tahunAjaranAktif'));
    }

    public function storePpdb(Request $request)
    {
        if (!Auth::guard('siswa')->check()) {
            $request->session()->put('url.intended', route('ppdb.index') . '#register');
            return redirect()->route('siswa.login', ['redirect' => route('ppdb.index')]);
        }

        $siswa = Auth::guard('siswa')->user();

        if ($siswa?->spmb_id) {
            return redirect()->route('siswa.ppdb.hasil-seleksi');
        }

        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();

        $validated = $request->validate([
            'nama_lengkap_anak' => 'required|string|max:255',
            'nik_anak' => 'required|digits:16|unique:spmb,nik_anak',
            'tempat_lahir_anak' => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'anak_ke' => 'required|integer|min:1',
            'tinggal_bersama' => 'required|string|max:50',
            'status_tempat_tinggal' => 'required|in:Milik Sendiri,Milik Keluarga,Kontrakan',
            'bahasa_sehari_hari' => 'required|string|max:100',

            'provinsi_rumah' => 'required|string|max:100',
            'kota_kabupaten_rumah' => 'required|string|max:100',
            'kecamatan_rumah' => 'required|string|max:100',
            'kelurahan_rumah' => 'required|string|max:100',
            'nama_jalan_rumah' => 'required|string|max:255',
        ]);

        $validated['tahun_ajaran_id'] = $tahunAjaranAktif?->id;
        $validated['status_pendaftaran'] = 'Menunggu Verifikasi';
        $validated['punya_saudara_sekolah_tk'] = $validated['punya_saudara_sekolah_tk'] ?? 'Tidak';
        $validated['jenis_daftar'] = $validated['jenis_daftar'] ?? 'Siswa Baru';

        $spmb = Spmb::create($validated);

        $siswa->spmb_id = $spmb->id;
        $siswa->tahun_ajaran_id = $tahunAjaranAktif?->id;
        $siswa->tahun_ajaran = $tahunAjaranAktif?->tahun_ajaran;
        $siswa->save();

        return redirect()->route('siswa.ppdb.hasil-seleksi')
            ->with('success', 'Pendaftaran PPDB berhasil dikirim. Data bersifat read-only.');
    }
}