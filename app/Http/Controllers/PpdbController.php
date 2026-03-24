<?php

namespace App\Http\Controllers;

use App\Models\Spmb;
use App\Models\SpmbDokumen;
use App\Models\TahunAjaran;
use App\Models\SpmbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PpdbController extends Controller
{
    public function index()
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
            $spmbSetting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->first();
            
            if ($spmbSetting) {
                $statusPendaftaran = $spmbSetting->getStatusPendaftaranHomepage();
            }
        }

        // Fixed case-sensitivity bug: 'Home.ppdb' instead of 'home.ppdb'
        return view('Home.ppdb', compact('tahunAjaranAktif', 'spmbSetting', 'statusPendaftaran'));
    }

    public function store(Request $request)
    {
        // Cek status pendaftaran terlebih dahulu
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $spmbSetting = null;
        $isPendaftaranDibuka = false;
        
        if ($tahunAjaranAktif) {
            $spmbSetting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)
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
            return redirect()->route('siswa.success');
        }

        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Pendaftaran belum dibuka (Tidak ada tahun ajaran aktif).');
        }

        $setting = SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
        if (!$setting) {
            return redirect()->back()->with('error', 'Pengaturan pendaftaran belum tersedia.');
        }

        $now = now();
        if ($now->lt($setting->pendaftaran_mulai) || $now->gt($setting->pendaftaran_selesai)) {
            return redirect()->back()->with('error', 'Maaf, masa pendaftaran PPDB telah berakhir atau belum dimulai.');
        }

        $validated = $request->validate([
            // Data Pribadi
            'nama_lengkap_anak' => 'required|string|max:255',
            'nama_panggilan_anak' => 'nullable|string|max:100',
            'nik_anak' => 'required|string|max:20|unique:spmb,nik_anak',
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
            'nik_ayah' => 'required|string|max:20',
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
            'nik_ibu' => 'required|string|max:20',
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
            'nik_wali' => 'nullable|string|max:20',
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
            'akte_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_orang_tua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

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

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = 'bukti_' . $spmb->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen/spmb', $filename, 'public');
            $spmb->dokumen()->create([
                'jenis_dokumen' => 'bukti_pembayaran',
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

        NotificationController::notifyNewSpmbRegistration($spmb);

        return redirect()->route('siswa.success')
            ->with('success', 'Pendaftaran PPDB berhasil dikirim. Data bersifat read-only.');
    }
}
