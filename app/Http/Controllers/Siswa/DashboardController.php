<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use App\Models\Spmb;
use App\Models\SpmbSetting;
use App\Models\TahunAjaran;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $siswa = auth('siswa')->user();
        
        // Ambil SPMB berdasarkan nik atau spmb_id di siswa
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = \App\Models\Spmb::find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = \App\Models\Spmb::where('nik_anak', $siswa->nik)
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        $isLulus = false;
        $showPengumumanLulus = false;
        
        if ($spmb) {
            $isLulus = $spmb->status_pendaftaran === 'Lulus';
            
            // Cek apakah waktu pengumuman sudah selesai (null-safe untuk relasi tahunAjaran)
            $tahunAjaranStr = optional($spmb->tahunAjaran)->tahun_ajaran ?? date('Y');
            $setting = \App\Models\SpmbSetting::where('tahun_ajaran_id', $spmb->tahun_ajaran_id)
                ->orWhere('tahun_ajaran', $tahunAjaranStr)
                ->first();
            if ($setting && $setting->status_pengumuman === 'published') {
                $now = now();
                $pengumumanSelesai = $setting->pengumuman_selesai;
                
                // Tampilkan notifikasi lulus jika waktu pengumuman sudah selesai
                if ($pengumumanSelesai && $now->gte($pengumumanSelesai)) {
                    $showPengumumanLulus = true;
                }
            }
        }
        
        // Hitung step saat ini
        $currentStep = 1;
        $stepLabels = ['Isi Formulir', 'Upload Dokumen', 'Verifikasi Admin', 'Pengumuman'];
        
        if ($spmb) {
            $currentStep = 2; // Sudah isi formulir
            if ($spmb->dokumen_terunggah) {
                $currentStep = 3; // Dokumen terunggah (nunggu verif)
                if ($spmb->dokumen_lengkap) {
                    $currentStep = 4; // Dokumen lengkap (nunggu pengumuman)
                    if ($spmb->status_pendaftaran === 'Lulus' || $spmb->status_pendaftaran === 'Tidak Lulus') {
                        $currentStep = 5; // Selesai
                    }
                }
            }
        }
        
        // Status dokumen - hanya menggunakan kolom yang ada di tabel spmb
        $dokumenStatus = [
            'akte' => $spmb ? ($spmb->verifikasi_akte ? 'verified' : 'pending') : 'pending',
            'kk'   => $spmb ? ($spmb->verifikasi_kk   ? 'verified' : 'pending') : 'pending',
            'ktp'  => $spmb ? ($spmb->verifikasi_ktp  ? 'verified' : 'pending') : 'pending',
            'foto' => $spmb ? ($spmb->foto_calon_siswa ? 'uploaded' : 'pending') : 'pending',
        ];
        
        // Pengumuman/berita terbaru (latestPublished() sudah include published() scope)
        $pengumuman = \App\Models\Berita::latestPublished(3)->get();
        
        // Fetch latest materials for this student
        $kelompokFull = "Kelompok " . ($siswa->kelompok ?? 'A');
        
        $materiTerbaru = \App\Models\MateriKbm::where(function($q) use ($siswa, $kelompokFull) {
            $q->where('kelas', $kelompokFull)
              ->orWhere('kelas', 'Semua Kelas');
        })
        ->where(function($q) use ($siswa) {
            if ($siswa->kelas) {
                $q->where(function($sub) use ($siswa) {
                    $sub->where('kelompok', $siswa->kelas)
                        ->orWhereNull('kelompok')
                        ->orWhere('kelompok', 'like', $siswa->kelompok . '%');
                });
            }
        })
        ->latest('tanggal_publish')
        ->take(3)
        ->get();

        // Fetch today's schedule
        $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::first();
        $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');
        
        $todaySchedule = [];
        if ($ta) {
            $todaySchedule = \App\Models\JadwalPelajaran::where('kelompok', $siswa->kelompok ?? 'A')
                ->where('tahun_ajaran_id', $ta->id)
                ->where('semester', $ta->semester)
                ->where('hari', $hariIni)
                ->orderBy('jam_mulai')
                ->get();
        }
        
        return view('siswa.dashboard', compact(
            'siswa', 
            'pengumuman', 
            'materiTerbaru', 
            'todaySchedule', 
            'spmb', 
            'isLulus', 
            'showPengumumanLulus',
            'currentStep',
            'stepLabels',
            'dokumenStatus'
        ));
    }

    public function profile()
    {
        $siswa = auth('siswa')->user();
        return view('siswa.profile', compact('siswa'));
    }

    public function formulir()
    {
        $siswa = auth('siswa')->user();
        
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = Spmb::find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = Spmb::where('nik_anak', $siswa->nik)->first();
        }

        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();

        // Jika sudah ada data SPMB, anggap sudah isi formulir (read-only)
        $readOnly = $spmb ? true : false;

        return view('siswa.formulir', compact('siswa', 'spmb', 'tahunAjaranAktif', 'tahunAjaran', 'readOnly'));
    }

    /**
     * Tampilkan hasil seleksi / pengumuman.
     */
    public function pengumuman()
    {
        $siswa = auth('siswa')->user();
        
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = Spmb::find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = Spmb::where('nik_anak', $siswa->nik)->first();
        }

        if (!$spmb) {
            return redirect()->route('siswa.formulir')->with('info', 'Silakan lengkapi formulir pendaftaran terlebih dahulu.');
        }

        $settingQuery = SpmbSetting::query();
        if ($spmb->tahun_ajaran_id) {
            $settingQuery->where('tahun_ajaran_id', $spmb->tahun_ajaran_id);
        }

        $setting = $settingQuery->latest('id')->first();

        return view('siswa.pengumuman', compact('siswa', 'spmb', 'setting'));
    }

    /**
     * Tampilkan halaman dokumen.
     */
    public function dokumen()
    {
        $siswa = auth('siswa')->user();
        
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = Spmb::with('dokumen')->find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = Spmb::where('nik_anak', $siswa->nik)
                ->with('dokumen')
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if (!$spmb) {
            return redirect()->route('siswa.formulir')->with('info', 'Silakan lengkapi formulir pendaftaran terlebih dahulu.');
        }

        $setting = SpmbSetting::where('tahun_ajaran_id', $spmb->tahun_ajaran_id)->first();
        
        // Map current docs
        $docs = $spmb->dokumen->groupBy('jenis_dokumen')->map->first();

        // Read-only logic for documents:
        // Read-only if (status is NOT 'Revisi Dokumen') AND (all 3 documents are uploaded)
        $countUploaded = $spmb->dokumen->whereIn('jenis_dokumen', ['akte_kelahiran', 'kartu_keluarga', 'ktp_orang_tua'])->count();
        $readOnly = ($spmb->status_pendaftaran !== 'Revisi Dokumen' && $countUploaded >= 3);

        return view('siswa.dokumen', compact('siswa', 'spmb', 'docs', 'setting', 'readOnly'));
    }

    /**
     * Store individual document.
     */
    public function storeDokumen(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:akte_kelahiran,kartu_keluarga,ktp_orang_tua',
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Up to 5MB
        ]);

        $siswa = auth('siswa')->user();
        
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = Spmb::find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = Spmb::where('nik_anak', $siswa->nik)->first();
        }

        if (!$spmb) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Check if already verified
        $verifField = 'verifikasi_';
        $type = $request->jenis_dokumen;
        if ($type == 'akte_kelahiran') $verifField .= 'akte';
        elseif ($type == 'kartu_keluarga') $verifField .= 'kk';
        elseif ($type == 'ktp_orang_tua') $verifField .= 'ktp';

        if ($spmb->$verifField) {
            return back()->with('error', 'Dokumen ini sudah diverifikasi dan tidak dapat diubah.');
        }

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $prefix = ($type == 'akte_kelahiran') ? 'akte' : (($type == 'kartu_keluarga') ? 'kk' : 'ktp');
            $filename = $prefix . '_' . $spmb->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen/spmb', $filename, 'public');

            // Find or create
            $dokumen = $spmb->dokumen()->where('jenis_dokumen', $type)->first();
            
            if ($dokumen) {
                // Delete old file if exists
                if (\Storage::disk('public')->exists($dokumen->path_file)) {
                    \Storage::disk('public')->delete($dokumen->path_file);
                }
                
                $dokumen->update([
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_file' => floor($file->getSize() / 1024), // in KB
                ]);
                
                $jenisLabel = match($type) {
                    'akte_kelahiran' => 'Akta Kelahiran',
                    'kartu_keluarga' => 'Kartu Keluarga',
                    'ktp_orang_tua' => 'KTP Orang Tua',
                    default => $type
                };
                
                $spmb->riwayatStatus()->create([
                    'status_sebelumnya' => $spmb->status_pendaftaran,
                    'status_baru' => $spmb->status_pendaftaran,
                    'keterangan' => 'Siswa mengunggah ulang dokumen: ' . $jenisLabel,
                    'diubah_oleh' => null,
                    'role_pengubah' => 'siswa'
                ]);
            } else {
                $dokumen = $spmb->dokumen()->create([
                    'jenis_dokumen' => $type,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_file' => floor($file->getSize() / 1024), // in KB
                ]);

                // Catat riwayat upload dokumen
                $jenisLabel = match($type) {
                    'akte_kelahiran' => 'Akta Kelahiran',
                    'kartu_keluarga' => 'Kartu Keluarga',
                    'ktp_orang_tua' => 'KTP Orang Tua',
                    default => $type
                };
                
                $spmb->riwayatStatus()->create([
                    'status_sebelumnya' => $spmb->status_pendaftaran,
                    'status_baru' => $spmb->status_pendaftaran,
                    'keterangan' => 'Siswa mengunggah dokumen: ' . $jenisLabel,
                    'diubah_oleh' => null,
                    'role_pengubah' => 'siswa'
                ]);
            }

            return back()->with('success', 'Dokumen ' . $dokumen->jenis_label . ' berhasil diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah dokumen.');
    }

    /**
     * Submit all documents.
     */
    public function submitPendaftaran(Request $request)
    {
        $siswa = auth('siswa')->user();
        
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = Spmb::find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = Spmb::where('nik_anak', $siswa->nik)->first();
        }

        if (!$spmb) {
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $isResubmission = $spmb->status_pendaftaran == 'Revisi Dokumen';

        // Update status to Menunggu Verifikasi if it was Revisi Dokumen
        if ($isResubmission) {
            $spmb->update([
                'status_pendaftaran' => 'Menunggu Verifikasi',
                'catatan_admin' => null,
                'catatan_admin_at' => null,
            ]);
        }

        $spmb->riwayatStatus()->create([
            'status_sebelumnya' => $isResubmission ? 'Revisi Dokumen' : $spmb->status_pendaftaran,
            'status_baru' => 'Menunggu Verifikasi',
            'keterangan' => $isResubmission
                ? 'Siswa telah mengirim ulang dokumen untuk verifikasi.'
                : 'Siswa telah mengirim dokumen pendaftaran untuk verifikasi.',
            'diubah_oleh' => null,
            'role_pengubah' => 'siswa',
        ]);

        NotificationController::sendToSiswa(
            siswaId: $siswa->id,
            type: 'system_documents_submission',
            title: 'Dokumen berhasil dikirim',
            body: $isResubmission
                ? 'Dokumen revisi Anda sudah kami terima kembali. Data akan kami periksa ulang dan hasil verifikasi akan ditampilkan di Notification System.'
                : 'Terima kasih telah mendaftar di TK PGRI Harapan Bangsa 1. Formulir dan dokumen Anda sudah kami terima, dan data Anda akan kami verifikasi.',
            data: [
                'url' => route('siswa.dokumen'),
                'spmb_id' => $spmb->id,
                'submission_type' => $isResubmission ? 'resubmission' : 'initial',
            ],
        );

        return redirect()->route('siswa.dashboard')->with('success', 'Dokumen pendaftaran telah dikirim untuk verifikasi.');
    }

    public function success()
    {
        $siswa = auth('siswa')->user();
        return view('siswa.success', compact('siswa'));
    }
}
