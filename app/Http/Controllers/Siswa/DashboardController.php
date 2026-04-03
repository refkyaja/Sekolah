<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use App\Models\Spmb;
use App\Models\SpmbSetting;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;


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
                
                // Tampilkan notifikasi lulus jika sudah dipublish DAN (waktu pengumuman sudah selesai atau manual publish)
                if ($spmb->is_published && (!$pengumumanSelesai || $now->gte($pengumumanSelesai))) {
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
                    if (($spmb->status_pendaftaran === 'Lulus' || $spmb->status_pendaftaran === 'Tidak Lulus') && $spmb->is_published) {
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
            'bukti_pembayaran' => $spmb ? ($spmb->verifikasi_bukti_transfer ? 'verified' : 'pending') : 'pending',
        ];
        
        // Pengumuman/berita terbaru
        if ($siswa->status_siswa === 'lulus') {
            $pengumuman = collect(); // Sembunyikan berita untuk alumni
        } else {
            $pengumuman = \App\Models\Berita::latestPublished(3)->get();
        }
        
        // Fetch latest materials for this student
        $kelompokFull = "Kelompok " . ($siswa->kelompok ?? 'A');
        
        $materiQuery = \App\Models\MateriKbm::where(function($q) use ($siswa, $kelompokFull) {
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
        });
        
        if ($siswa->status_siswa === 'lulus' && $siswa->tanggal_keluar) {
            $materiQuery->where('tanggal_publish', '<=', $siswa->tanggal_keluar);
        }
        
        $materiTerbaru = $materiQuery->latest('tanggal_publish')
        ->take(3)
        ->get();

        // Fetch today's schedule
        if ($siswa->status_siswa === 'lulus' && $siswa->tahun_ajaran_id) {
            $ta = \App\Models\TahunAjaran::find($siswa->tahun_ajaran_id);
        } else {
            $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::latest()->first();
        }
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

    /**
     * Tampilkan daftar notifikasi lengkap untuk siswa.
     */
    public function notifications()
    {
        $siswa = auth('siswa')->user();
        
        $spmb = null;
        if ($siswa->spmb_id) {
            $spmb = \App\Models\Spmb::with('dokumen')->find($siswa->spmb_id);
        }
        
        if (!$spmb && $siswa->nik) {
            $spmb = \App\Models\Spmb::with('dokumen')
                ->where('nik_anak', $siswa->nik)
                ->latest('created_at')
                ->first();
        }

        // 1. Ambil notifikasi dari Database
        $dbNotifications = \App\Models\Notification::where(function ($q) use ($siswa) {
            $q->where('target_user_id', $siswa->id)
              ->orWhere(function ($q2) use ($siswa) {
                  $q2->whereNull('target_user_id')
                     ->whereJsonContains('target_roles', 'siswa')
                     ->where(function ($q3) use ($siswa) {
                         $q3->whereNull('data->recipient_siswa_id')
                            ->orWhere('data->recipient_siswa_id', $siswa->id);
                     });
              });
        })
        ->orderByDesc('created_at')
        ->limit(100) // Ambil 100 terakhir untuk halaman lengkap
        ->get()
        ->map(fn($n) => [
            'id'        => $n->id,
            'type'      => $n->type,
            'title'     => $n->title,
            'body'      => $n->body,
            'data'      => $n->data,
            'is_unread' => $n->isUnread(),
            'created_at'=> $n->created_at,
            'time_ago'  => $n->created_at->diffForHumans(),
            'sort_at'   => $n->created_at?->timestamp ?? now()->timestamp,
        ])->toArray();

        // 2. Build System Notifications
        $systemNotifications = [];
        
        // Welcome
        $systemNotifications[] = [
            'id' => 'system-welcome',
            'type' => 'system_welcome',
            'title' => 'Selamat datang di Portal PPDB',
            'body' => 'Gunakan halaman ini untuk memantau seluruh riwayat pendaftaran Anda.',
            'data' => ['url' => route('siswa.dashboard')],
            'is_unread' => false,
            'created_at' => $siswa->created_at,
            'time_ago' => $siswa->created_at->diffForHumans(),
            'sort_at' => $siswa->created_at->timestamp,
        ];

        if (!$spmb) {
            $systemNotifications[] = [
                'id' => 'system-start-registration',
                'type' => 'system_start_registration',
                'title' => 'Mulai Pendaftaran Anda',
                'body' => 'Anda belum mengisi formulir pendaftaran. Silakan mulai sekarang.',
                'data' => ['url' => route('siswa.formulir')],
                'is_unread' => false,
                'created_at' => now(),
                'time_ago' => 'Baru saja',
                'sort_at' => now()->timestamp,
            ];
        } else {
            // Document Status
            if (!$spmb->dokumen_terunggah) {
                $systemNotifications[] = [
                    'id' => 'system-formulir-' . $spmb->id,
                    'type' => 'system_formulir',
                    'title' => 'Formulir Diterima',
                    'body' => 'Silakan lengkapi dokumen pendukung Anda.',
                    'data' => ['url' => route('siswa.dokumen')],
                    'is_unread' => false,
                    'created_at' => $spmb->created_at,
                    'time_ago' => $spmb->created_at->diffForHumans(),
                    'sort_at' => $spmb->created_at->timestamp,
                ];
            } else {
                $documentsAt = $spmb->dokumen->max('updated_at') ?? $spmb->created_at;
                $systemNotifications[] = [
                    'id' => 'system-documents-' . $spmb->id,
                    'type' => 'system_documents',
                    'title' => 'Dokumen Terverifikasi / Sedang Diperiksa',
                    'body' => 'Semua dokumen wajib telah kami terima.',
                    'data' => ['url' => route('siswa.pengumuman')],
                    'is_unread' => false,
                    'created_at' => $documentsAt,
                    'time_ago' => $documentsAt->diffForHumans(),
                    'sort_at' => $documentsAt->timestamp,
                ];
            }
        }

        // 3. Gabungkan dan Urutkan
        $allNotifications = array_merge($systemNotifications, $dbNotifications);
        usort($allNotifications, fn ($a, $b) => ($b['sort_at'] ?? 0) <=> ($a['sort_at'] ?? 0));

        return view('siswa.notifications', compact('siswa', 'allNotifications'));
    }

    /**
     * Update the student's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $siswa = auth('siswa')->user();
        $oldPhoto = $siswa->foto;

        // Hapus foto lama jika ada dan bukan URL eksternal
        if ($oldPhoto && !\Str::startsWith($oldPhoto, ['http://', 'https://']) && \Storage::disk('public')->exists($oldPhoto)) {
            \Storage::disk('public')->delete($oldPhoto);
        }

        // Upload foto baru
        $path = $request->file('photo')->store('profile-photos', 'public');
        $siswa->foto = $path;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui',
            'photo_url' => $siswa->foto_url
        ]);
    }

    /**
     * Update the student's password.
     */
    public function updatePassword(Request $request)
    {
        $siswa = auth('siswa')->user();

        // 1. Restriction for Google/External login
        if ($siswa->provider) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda terhubung dengan Google. Silakan ubah password melalui pengaturan akun Google Anda.'
            ], 422);
        }

        // 2. Validation
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // 3. Verify current password
        if (!Hash::check($request->current_password, $siswa->password)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'current_password' => ['Password saat ini tidak cocok.']
                ],
                'message' => 'Password saat ini salah.'
            ], 422);
        }

        // 4. Update password
        $siswa->password = Hash::make($request->new_password);
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui.'
        ]);
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

        // Status override: Jika belum dipublish, paksa status ke 'Menunggu Verifikasi' atau 'Pengumuman Belum Tersedia'
        if (!$spmb->is_published) {
            $spmb->status_pendaftaran = 'Menunggu Pengumuman';
        }

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

        // Read-only if (status is NOT 'Revisi Dokumen') AND (all 4 documents are uploaded)
        $countUploaded = $spmb->dokumen->whereIn('jenis_dokumen', ['akte_kelahiran', 'kartu_keluarga', 'ktp_orang_tua', 'bukti_pembayaran'])->count();
        $readOnly = ($spmb->status_pendaftaran !== 'Revisi Dokumen' && $countUploaded >= 4);

        return view('siswa.dokumen', compact('siswa', 'spmb', 'docs', 'setting', 'readOnly'));
    }

    /**
     * Store individual document.
     */
    public function storeDokumen(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:akte_kelahiran,kartu_keluarga,ktp_orang_tua,bukti_pembayaran',
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
        elseif ($type == 'bukti_pembayaran') $verifField .= 'bukti_transfer';

        if ($spmb->$verifField) {
            return back()->with('error', 'Dokumen ini sudah diverifikasi dan tidak dapat diubah.');
        }

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $prefix = match($type) {
                'akte_kelahiran' => 'akte',
                'kartu_keluarga' => 'kk',
                'ktp_orang_tua' => 'ktp',
                'bukti_pembayaran' => 'bukti',
                default => 'doc'
            };
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
                    'bukti_pembayaran' => 'Bukti Pembayaran',
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
                    'bukti_pembayaran' => 'Bukti Pembayaran',
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

    /**
     * Tampilkan data kehadiran siswa.
     */
    public function kehadiran(Request $request)
    {
        $siswa = auth('siswa')->user();
        $query = \App\Models\Absensi::where('siswa_id', $siswa->id);
        
        if ($siswa->status_siswa === 'lulus' && $siswa->tanggal_keluar) {
            $query->where('tanggal', '<=', $siswa->tanggal_keluar);
        }
        
        $absensi = $query->orderBy('tanggal', 'desc')->get();

        $viewMode = $request->query('mode', 'calendar');

        return view('siswa.kehadiran', compact('siswa', 'absensi', 'viewMode'));
    }

    /**
     * Tampilkan materi KBM.
     */
    public function materi(Request $request)
    {
        $siswa = auth('siswa')->user();
        $kelompok = $request->query('kelompok', $siswa->kelompok ?? 'A');
        
        $kelompokFull = "Kelompok " . $kelompok;

        $query = \App\Models\MateriKbm::where(function($q) use ($kelompokFull) {
                $q->where('kelas', $kelompokFull)
                  ->orWhere('kelas', 'Semua Kelas');
            });
            
        if ($siswa->status_siswa === 'lulus' && $siswa->tanggal_keluar) {
            $query->where('tanggal_publish', '<=', $siswa->tanggal_keluar);
        }

        $materi = $query->latest('tanggal_publish')
            ->paginate(10);

        return view('siswa.materi', compact('siswa', 'materi', 'kelompok'));
    }

    /**
     * Tampilkan jadwal pelajaran.
     */
    public function jadwal()
    {
        $siswa = auth('siswa')->user();
        
        if ($siswa->status_siswa === 'lulus' && $siswa->tahun_ajaran_id) {
            $ta = \App\Models\TahunAjaran::find($siswa->tahun_ajaran_id);
        } else {
            $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::latest()->first();
        }

        $jadwal = [];
        if ($ta) {
            $jadwal = \App\Models\JadwalPelajaran::where('kelompok', $siswa->kelompok ?? 'A')
                ->where('tahun_ajaran_id', $ta->id)
                ->where('semester', $ta->semester)
                ->get()
                ->groupBy('hari');
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('siswa.jadwal', compact('siswa', 'jadwal', 'ta', 'hariList'));
    }
}
