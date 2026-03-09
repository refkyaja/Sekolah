<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Program;
use App\Models\Testimoni;
use App\Models\BukuTamu;
use App\Models\Spmb;
use App\Models\SpmbDokumen;
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
        
        // Get SPMB settings untuk tahun ajaran aktif
        $spmbSetting = null;
        $statusPendaftaran = [
            'is_dibuka' => false,
            'pesan_status' => 'Pendaftaran belum dibuka',
            'tanggal_mulai' => null,
            'tanggal_selesai' => null,
            'status_class' => 'gray',
            'icon' => 'schedule'
        ];
        
        if ($tahunAjaranAktif) {
            $spmbSetting = \App\Models\SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->first();
            
            if ($spmbSetting) {
                $statusPendaftaran = $spmbSetting->getStatusPendaftaranHomepage();
            }
        }

        return view('home.ppdb', compact('tahunAjaranAktif', 'spmbSetting', 'statusPendaftaran'));
    }

    public function storePpdb(Request $request)
    {
        // Cek status pendaftaran terlebih dahulu
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $spmbSetting = null;
        $isPendaftaranDibuka = false;
        
        if ($tahunAjaranAktif) {
            $spmbSetting = \App\Models\SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->first();
            
            if ($spmbSetting) {
                $isPendaftaranDibuka = $spmbSetting->isPendaftaranDibuka();
            }
        }
        
        // Jika pendaftaran tidak dibuka, redirect dengan pesan error
        if (!$isPendaftaranDibuka) {
            $statusText = 'belum tersedia';
            if ($spmbSetting) {
                if ($spmbSetting->isPendaftaranAkanDibuka()) {
                    $statusText = 'belum dibuka';
                } elseif ($spmbSetting->isPendaftaranDitutup()) {
                    $statusText = 'sudah ditutup';
                }
            }
            
            return redirect()->route('ppdb.index')
                ->with('error', 'Pendaftaran PPDB saat ini ' . $statusText)
                ->withFragment('register');
        }

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
            // Data Pribadi
            'nama_lengkap_anak' => 'required|string|max:255',
            'nama_panggilan_anak' => 'nullable|string|max:100',
            'nik_anak' => 'required|digits:16|unique:spmb,nik_anak',
            'tempat_lahir_anak' => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'anak_ke' => 'required|integer|min:1',
            'tinggal_bersama' => 'required|string|max:50',
            'status_tempat_tinggal' => 'required|in:Milik Sendiri,Milik Keluarga,Kontrakan',
            'bahasa_sehari_hari' => 'required|string|max:100',
            'jarak_rumah_ke_sekolah' => 'nullable|integer',
            'waktu_tempuh_ke_sekolah' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'golongan_darah' => 'nullable|string|max:5',
            'penyakit_pernah_diderita' => 'nullable|string',
            'imunisasi_pernah_diterima' => 'nullable|string',

            // Alamat Rumah
            'provinsi_rumah' => 'required|string|max:100',
            'kota_kabupaten_rumah' => 'required|string|max:100',
            'kecamatan_rumah' => 'required|string|max:100',
            'kelurahan_rumah' => 'required|string|max:100',
            'nama_jalan_rumah' => 'required|string|max:255',
            'alamat_kk_sama' => 'nullable|boolean',

            // Alamat KK
            'provinsi_kk' => 'nullable|string|max:100',
            'kota_kabupaten_kk' => 'nullable|string|max:100',
            'kecamatan_kk' => 'nullable|string|max:100',
            'kelurahan_kk' => 'nullable|string|max:100',
            'nama_jalan_kk' => 'nullable|string|max:255',
            'alamat_kk' => 'nullable|string',

            // Data Ayah
            'nama_lengkap_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|digits:16',
            'tempat_lahir_ayah' => 'required|string|max:100',
            'tanggal_lahir_ayah' => 'required|date',
            'pendidikan_ayah' => 'nullable|string|max:50',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'bidang_pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_per_bulan_ayah' => 'nullable|string|max:50',
            'nomor_telepon_ayah' => 'required|string|max:16',
            'email_ayah' => 'nullable|email|max:100',

            // Data Ibu
            'nama_lengkap_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|digits:16',
            'tempat_lahir_ibu' => 'required|string|max:100',
            'tanggal_lahir_ibu' => 'required|date',
            'pendidikan_ibu' => 'nullable|string|max:50',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'bidang_pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_per_bulan_ibu' => 'nullable|string|max:50',
            'nomor_telepon_ibu' => 'required|string|max:16',
            'email_ibu' => 'nullable|email|max:100',

            // Data Wali
            'punya_wali' => 'nullable|boolean',
            'nama_lengkap_wali' => 'nullable|string|max:255',
            'hubungan_dengan_anak' => 'nullable|string|max:50',
            'nik_wali' => 'nullable|digits:16',
            'tempat_lahir_wali' => 'nullable|string|max:100',
            'tanggal_lahir_wali' => 'nullable|date',
            'pendidikan_wali' => 'nullable|string|max:50',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'nomor_telepon_wali' => 'nullable|string|max:16',
            'email_wali' => 'nullable|email|max:100',

            // Informasi Tambahan
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'jenis_daftar' => 'required|in:Siswa Baru,Pindahan',
            'sumber_informasi_ppdb' => 'nullable|string|max:100',
            'punya_saudara_sekolah_tk' => 'nullable|in:Ya,Tidak',

            // Dokumen
            'akte_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_orang_tua' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Konfirmasi
            'konfirmasi_data' => 'required|accepted',
        ]);

        $validated['tahun_ajaran_id'] = $tahunAjaranAktif?->id;
        $validated['status_pendaftaran'] = 'Menunggu Verifikasi';
        $validated['punya_saudara_sekolah_tk'] = $validated['punya_saudara_sekolah_tk'] ?? 'Tidak';
        $validated['alamat_kk_sama'] = $request->has('alamat_kk_sama');
        $validated['punya_wali'] = $request->has('punya_wali');

        $spmb = Spmb::create($validated);

        // Handle file uploads
        if ($request->hasFile('akte_kelahiran')) {
            $file = $request->file('akte_kelahiran');
            $filename = 'akte_' . $spmb->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen/spmb', $filename, 'public');
            $spmb->dokumen()->create([
                'jenis_dokumen' => 'akte_kelahiran',
                'path_file' => 'dokumen/spmb/' . $filename,
                'nama_file' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'ukuran_file' => $file->getSize(),
            ]);
        }

        if ($request->hasFile('kartu_keluarga')) {
            $file = $request->file('kartu_keluarga');
            $filename = 'kk_' . $spmb->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen/spmb', $filename, 'public');
            $spmb->dokumen()->create([
                'jenis_dokumen' => 'kartu_keluarga',
                'path_file' => 'dokumen/spmb/' . $filename,
                'nama_file' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'ukuran_file' => $file->getSize(),
            ]);
        }

        if ($request->hasFile('ktp_orang_tua')) {
            $file = $request->file('ktp_orang_tua');
            $filename = 'ktp_' . $spmb->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen/spmb', $filename, 'public');
            $spmb->dokumen()->create([
                'jenis_dokumen' => 'ktp_orang_tua',
                'path_file' => 'dokumen/spmb/' . $filename,
                'nama_file' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'ukuran_file' => $file->getSize(),
            ]);
        }

        $siswa->spmb_id = $spmb->id;
        $siswa->tahun_ajaran_id = $tahunAjaranAktif?->id;
        $siswa->tahun_ajaran = $tahunAjaranAktif?->tahun_ajaran;
        $siswa->save();

        return redirect()->route('siswa.ppdb.hasil-seleksi')
            ->with('success', 'Pendaftaran PPDB berhasil dikirim. Data bersifat read-only.');
    }
}