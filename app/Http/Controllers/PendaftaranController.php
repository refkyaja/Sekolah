<?php

namespace App\Http\Controllers;

use App\Models\Spmb;
use App\Models\SpmbDokumen;
use App\Models\SpmbSetting;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    // ==================== STEP 1: DATA PRIBADI ====================
    private function checkAuth()
    {
        if (!auth('siswa')->check()) {
            return redirect()->route('siswa.login')->with('error', 'Silakan login terlebih dahulu untuk mendaftar.');
        }
        return null;
    }

    public function step1()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $setting = $this->getActiveSetting();
        if ($this->isPendaftaranClosed($setting)) {
            return redirect()->route('siswa.dashboard')->with('error', 'Periode pendaftaran belum/sudah dibuka.');
        }

        $data = session('pendaftaran.step1', []);
        return view('Home.spmb.pendaftaran.step1', compact('data'));
    }

    public function step1Store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $validator = Validator::make($request->all(), [
            'nama_lengkap_anak'  => 'required|string|max:255',
            'nama_panggilan_anak'=> 'nullable|string|max:100',
            'jenis_kelamin'      => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir_anak'  => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'agama'              => 'required|string|max:50',
            'alamat_lengkap'     => 'required|string|max:500',
        ], [
            'nama_lengkap_anak.required'  => 'Nama lengkap anak wajib diisi.',
            'jenis_kelamin.required'      => 'Jenis kelamin wajib dipilih.',
            'tempat_lahir_anak.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir_anak.required' => 'Tanggal lahir wajib diisi.',
            'agama.required'              => 'Agama wajib dipilih.',
            'alamat_lengkap.required'     => 'Alamat lengkap wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('siswa.pendaftaran.step1')
                ->withErrors($validator)
                ->withInput();
        }

        // Validate minimum age (3 years)
        $usia = Carbon::parse($request->tanggal_lahir_anak)->age;
        if ($usia < 3) {
            return redirect()->route('siswa.pendaftaran.step1')
                ->with('error', 'Usia calon siswa minimal 3 tahun.')
                ->withInput();
        }

        session(['pendaftaran.step1' => $request->only([
            'nama_lengkap_anak', 'nama_panggilan_anak', 'jenis_kelamin',
            'tempat_lahir_anak', 'tanggal_lahir_anak', 'agama', 'alamat_lengkap',
        ])]);

        return redirect()->route('siswa.pendaftaran.step2');
    }

    // ==================== STEP 2: DATA ORANG TUA ====================

    public function step2()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        if (!session('pendaftaran.step1')) {
            return redirect()->route('siswa.pendaftaran.step1')->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        $data = session('pendaftaran.step2', []);
        return view('Home.spmb.pendaftaran.step2', compact('data'));
    }

    public function step2Store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        if (!session('pendaftaran.step1')) {
            return redirect()->route('siswa.pendaftaran.step1');
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap_ayah'       => 'required|string|max:255',
            'nik_ayah'                => 'required|digits:16',
            'pekerjaan_ayah'          => 'nullable|string|max:100',
            'pendidikan_ayah'         => 'nullable|string|max:100',
            'nama_lengkap_ibu'        => 'required|string|max:255',
            'nik_ibu'                 => 'required|digits:16',
            'pekerjaan_ibu'           => 'nullable|string|max:100',
            'pendidikan_ibu'          => 'nullable|string|max:100',
            'nomor_telepon'           => 'required|string|max:20',
            'email'                   => 'nullable|email|max:255',
            'penghasilan_gabungan'    => 'nullable|string|max:100',
        ], [
            'nama_lengkap_ayah.required' => 'Nama lengkap ayah wajib diisi.',
            'nik_ayah.required'          => 'NIK ayah wajib diisi.',
            'nik_ayah.digits'            => 'NIK ayah harus 16 digit angka.',
            'nama_lengkap_ibu.required'  => 'Nama lengkap ibu wajib diisi.',
            'nik_ibu.required'           => 'NIK ibu wajib diisi.',
            'nik_ibu.digits'             => 'NIK ibu harus 16 digit angka.',
            'nomor_telepon.required'     => 'Nomor WhatsApp aktif wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('siswa.pendaftaran.step2')
                ->withErrors($validator)
                ->withInput();
        }

        session(['pendaftaran.step2' => $request->only([
            'nama_lengkap_ayah', 'nik_ayah', 'pekerjaan_ayah', 'pendidikan_ayah',
            'nama_lengkap_ibu', 'nik_ibu', 'pekerjaan_ibu', 'pendidikan_ibu',
            'nomor_telepon', 'email', 'penghasilan_gabungan',
        ])]);

        return redirect()->route('siswa.pendaftaran.step3');
    }

    // ==================== STEP 3: UPLOAD BERKAS ====================

    public function step3()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        if (!session('pendaftaran.step1') || !session('pendaftaran.step2')) {
            return redirect()->route('siswa.pendaftaran.step1')->with('error', 'Silakan lengkapi langkah sebelumnya.');
        }

        $uploadedFiles = session('pendaftaran.step3.files', []);
        return view('Home.spmb.pendaftaran.step3', compact('uploadedFiles'));
    }

    public function step3Store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        if (!session('pendaftaran.step1') || !session('pendaftaran.step2')) {
            return redirect()->route('siswa.pendaftaran.step1');
        }

        $validator = Validator::make($request->all(), [
            'kartu_keluarga'   => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'akta_kelahiran'   => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'ijazah'           => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'pas_foto'         => 'required|file|mimes:jpeg,jpg,png|max:1024',
        ], [
            'kartu_keluarga.required'  => 'Kartu Keluarga wajib diunggah.',
            'akta_kelahiran.required'  => 'Akta Kelahiran wajib diunggah.',
            'pas_foto.required'        => 'Pas Foto wajib diunggah.',
            'kartu_keluarga.max'       => 'Ukuran KK maksimal 2MB.',
            'akta_kelahiran.max'       => 'Ukuran Akta Kelahiran maksimal 2MB.',
            'pas_foto.max'             => 'Ukuran Pas Foto maksimal 1MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('siswa.pendaftaran.step3')
                ->withErrors($validator)
                ->withInput();
        }

        // Store files temporarily
        $files = [];
        $fileFields = ['kartu_keluarga', 'akta_kelahiran', 'ijazah', 'pas_foto'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('spmb/temp', 'local');
                $files[$field] = [
                    'path'          => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size'          => round($file->getSize() / 1024, 2),
                    'mime'          => $file->getMimeType(),
                ];
            }
        }

        session(['pendaftaran.step3.files' => $files]);

        return redirect()->route('siswa.pendaftaran.step4');
    }

    // ==================== STEP 4: REVIEW & SUBMIT ====================

    public function step4()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $step1 = session('pendaftaran.step1');
        $step2 = session('pendaftaran.step2');
        $step3 = session('pendaftaran.step3.files');

        if (!$step1 || !$step2 || !$step3) {
            return redirect()->route('siswa.pendaftaran.step1')->with('error', 'Silakan lengkapi semua langkah pendaftaran.');
        }

        return view('Home.spmb.pendaftaran.step4', compact('step1', 'step2', 'step3'));
    }

    public function submit(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $step1 = session('pendaftaran.step1');
        $step2 = session('pendaftaran.step2');
        $step3Files = session('pendaftaran.step3.files');

        if (!$step1 || !$step2 || !$step3Files) {
            return redirect()->route('siswa.pendaftaran.step1')->with('error', 'Data pendaftaran tidak lengkap. Silakan ulangi proses pendaftaran.');
        }

        // Check if confirmed
        $request->validate([
            'konfirmasi' => 'required|accepted',
        ], [
            'konfirmasi.required'  => 'Anda harus menyetujui pernyataan kebenaran data.',
            'konfirmasi.accepted'  => 'Anda harus menyetujui pernyataan kebenaran data.',
        ]);

        DB::beginTransaction();

        try {
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();

            if (!$tahunAjaranAktif) {
                return redirect()->route('siswa.dashboard')->with('error', 'Tahun ajaran belum aktif. Hubungi administrator.');
            }

            // Build the SPMB data from session
            $noPendaftaran = $this->generateNomorPendaftaran();

            // Map address field
            $alamatParts = explode(',', $step1['alamat_lengkap'], 2);

            $spmbData = [
                'no_pendaftaran'    => $noPendaftaran,
                'tahun_ajaran_id'   => $tahunAjaranAktif->id,
                'status_pendaftaran'=> 'Menunggu Verifikasi',

                // Step 1 - Data Anak
                'nama_lengkap_anak'  => $step1['nama_lengkap_anak'],
                'nama_panggilan_anak'=> $step1['nama_panggilan_anak'] ?? null,
                'jenis_kelamin'      => $step1['jenis_kelamin'],
                'tempat_lahir_anak'  => $step1['tempat_lahir_anak'],
                'tanggal_lahir_anak' => $step1['tanggal_lahir_anak'],
                'agama'              => $step1['agama'],
                'nama_jalan_rumah'   => $step1['alamat_lengkap'],

                // Step 2 - Data Orang Tua
                'nama_lengkap_ayah'       => $step2['nama_lengkap_ayah'],
                'nik_ayah'                => $step2['nik_ayah'],
                'pekerjaan_ayah'          => $step2['pekerjaan_ayah'] ?? null,
                'pendidikan_ayah'         => $step2['pendidikan_ayah'] ?? null,
                'nama_lengkap_ibu'        => $step2['nama_lengkap_ibu'],
                'nik_ibu'                 => $step2['nik_ibu'],
                'pekerjaan_ibu'           => $step2['pekerjaan_ibu'] ?? null,
                'pendidikan_ibu'          => $step2['pendidikan_ibu'] ?? null,
                'nomor_telepon_ayah'      => $step2['nomor_telepon'],
                'email_ayah'              => $step2['email'] ?? null,
                'penghasilan_per_bulan_ayah' => $step2['penghasilan_gabungan'] ?? null,

                // Defaults
                'verifikasi_akte'           => false,
                'verifikasi_kk'             => false,
                'verifikasi_ktp'            => false,
                'verifikasi_bukti_transfer' => false,
                'jenis_daftar'              => 'Siswa Baru',
                'punya_saudara_sekolah_tk'  => 'Tidak',
            ];

            $spmb = Spmb::create($spmbData);

            // Move temp files to permanent storage and create SpmbDokumen records
            $dokumenMap = [
                'kartu_keluarga' => 'kk',
                'akta_kelahiran' => 'akte',
                'ijazah'         => 'ijazah',
                'pas_foto'       => 'foto',
            ];

            foreach ($step3Files as $field => $fileInfo) {
                $jenis = $dokumenMap[$field] ?? $field;
                $newPath = 'spmb/dokumen/' . $jenis . '/' . $spmb->id . '/' . basename($fileInfo['path']);

                // Move from tmp to permanent
                if (Storage::disk('local')->exists($fileInfo['path'])) {
                    $contents = Storage::disk('local')->get($fileInfo['path']);
                    Storage::disk('public')->put($newPath, $contents);
                    Storage::disk('local')->delete($fileInfo['path']);
                }

                SpmbDokumen::create([
                    'spmb_id'       => $spmb->id,
                    'jenis_dokumen' => $jenis,
                    'nama_file'     => $fileInfo['original_name'],
                    'path_file'     => $newPath,
                    'mime_type'     => $fileInfo['mime'],
                    'ukuran_file'   => $fileInfo['size'],
                ]);
            }

            DB::commit();

            // Clear all session data
            session()->forget(['pendaftaran.step1', 'pendaftaran.step2', 'pendaftaran.step3.files']);

            return redirect()->route('siswa.dashboard')
                ->with('success', 'Pendaftaran berhasil dikirim! Nomor Pendaftaran Anda: ' . $noPendaftaran);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pendaftaran Submit Error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            return redirect()->route('siswa.pendaftaran.step4')
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // ==================== HELPERS ====================

    private function generateNomorPendaftaran(): string
    {
        $tahun = date('Y');
        $bulan = date('m');

        $lastData = Spmb::whereYear('created_at', $tahun)
            ->orderBy('no_pendaftaran', 'desc')
            ->first();

        $newNumber = $lastData
            ? str_pad(intval(substr($lastData->no_pendaftaran, -4)) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        return 'PPDB-' . $tahun . $bulan . '-' . $newNumber;
    }

    private function getActiveSetting(): ?SpmbSetting
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        if (!$tahunAjaranAktif) return null;

        return SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first();
    }

    private function isPendaftaranClosed(?SpmbSetting $setting): bool
    {
        if (!$setting) return true;
        if (!$setting->pendaftaran_mulai || !$setting->pendaftaran_selesai) return true;

        return !now()->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);
    }
}
