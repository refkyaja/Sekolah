<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\User;
use App\Models\Spmb;
use App\Models\TahunAjaran;
use App\Models\BukuTamu;
use App\Models\Absensi;
use App\Models\MateriKbm;
use App\Models\KalenderAkademik;
use App\Models\JadwalPelajaran;
use App\Models\Berita;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
        
        // Data Siswa
        $total_siswa = Siswa::aktif()->count();
        $siswa_aktif = Siswa::aktif()->count();
        $siswa_lulus = Siswa::where('status_siswa', 'lulus')->count();
        $kelompok_a = Siswa::aktif()->where('kelompok', 'A')->count();
        $kelompok_b = Siswa::aktif()->where('kelompok', 'B')->count();
        $laki_laki = Siswa::aktif()->where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = Siswa::aktif()->where('jenis_kelamin', 'Perempuan')->count();
        
        // 5 siswa terbaru
        $siswa_terbaru = Siswa::with(['spmb'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Data Tahun Ajaran
        $tahun_ajaran_list = TahunAjaran::orderBy('tahun', 'desc')->get();
        $tahun_ajaran_aktif = $tahunAjaranAktif;
        
        // Data Materi KBM
        $total_materi = MateriKbm::count();
        $materi_terbaru = MateriKbm::with(['mapel'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Data Kalender Akademik
        $total_kalender = KalenderAkademik::count();
        $kalender_terbaru = KalenderAkademik::orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();
        
        // Data Jadwal Pelajaran
        $total_jadwal = JadwalPelajaran::count();
        $jadwal_hari_ini = JadwalPelajaran::with(['guru', 'mapel', 'kelas'])
            ->where('hari', now()->format('l'))
            ->orderBy('jam_mulai')
            ->get();
        
        // Data PPDB (SPMB)
        $total_ppdb = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count();
        $pendaftaran_baru = Spmb::where('status_pendaftaran', 'Menunggu Verifikasi')
            ->when($tahunAjaranId, function($query) use ($tahunAjaranId) {
                return $query->where('tahun_ajaran_id', $tahunAjaranId);
            })
            ->count();
        
        $spmb_statistics = [
            'menunggu' => Spmb::where('status_pendaftaran', 'Menunggu Verifikasi')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count(),
            'diterima' => Spmb::where('status_pendaftaran', 'Lulus')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count(),
            'ditolak' => Spmb::where('status_pendaftaran', 'Tidak Lulus')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count(),
            'total' => Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count(),
        ];
        
        // Recent Pendaftaran SPMB (5 terbaru)
        $recent_pendaftaran = Spmb::with(['tahunAjaran'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Data Informasi Publik (Berita)
        $total_berita = Berita::count();
        $berita_terbaru = Berita::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistik Absensi Hari Ini
        $absensi_hari_ini = Absensi::whereDate('tanggal', today())->count();
        $persen_absen = $total_siswa > 0
            ? round(min(100, ($absensi_hari_ini / $total_siswa) * 100), 1)
            : 0;
        
        // Data Guru
        $total_guru = Guru::count();
        
        // Data Buku Tamu
        $total_bukutamu = BukuTamu::count();
        $bukutamu_hari_ini = BukuTamu::whereDate('created_at', today())->count();
        
        // Chart data untuk dashboard
        $chart_siswa_per_kelompok = Siswa::aktif()
            ->select('kelompok', DB::raw('count(*) as total'))
            ->groupBy('kelompok')
            ->get();
        
        $chart_spmb_per_status = collect($spmb_statistics)->except('total');
        
        // Grafik pendaftaran per bulan (tahun ini)
        $grafik_pendaftaran_bulanan = Spmb::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        // Compile statistics untuk cards
        $stats = [
            'siswa_aktif' => $siswa_aktif,
            'siswa_lulus' => $siswa_lulus,
            'total_siswa' => $total_siswa,
            'total_guru' => $total_guru,
            'pendaftaran_baru' => $pendaftaran_baru,
            'kelompok_a' => $kelompok_a,
            'kelompok_b' => $kelompok_b,
            'laki_laki' => $laki_laki,
            'perempuan' => $perempuan,
            'spmb_menunggu' => $spmb_statistics['menunggu'] ?? 0,
            'spmb_diterima' => $spmb_statistics['diterima'] ?? 0,
            'spmb_ditolak' => $spmb_statistics['ditolak'] ?? 0,
            'ppdb_total' => $spmb_statistics['total'] ?? 0,
            'total_materi' => $total_materi,
            'total_kalender' => $total_kalender,
            'total_jadwal' => $total_jadwal,
            'total_berita' => $total_berita,
            'absensi_hari_ini' => $absensi_hari_ini,
            'persen_absen' => $persen_absen,
            'total_bukutamu' => $total_bukutamu,
            'bukutamu_hari_ini' => $bukutamu_hari_ini,
        ];

        return view('operator.dashboard', compact(
            'total_siswa',
            'total_guru',
            'siswa_terbaru',
            'tahun_ajaran_list',
            'tahun_ajaran_aktif',
            'total_materi',
            'materi_terbaru',
            'total_kalender',
            'kalender_terbaru',
            'total_jadwal',
            'jadwal_hari_ini',
            'total_ppdb',
            'pendaftaran_baru',
            'spmb_statistics',
            'recent_pendaftaran',
            'total_berita',
            'berita_terbaru',
            'absensi_hari_ini',
            'persen_absen',
            'total_bukutamu',
            'bukutamu_hari_ini',
            'chart_siswa_per_kelompok',
            'chart_spmb_per_status',
            'grafik_pendaftaran_bulanan',
            'stats'
        ));
    }
    
    /**
     * Get SPMB statistics for AJAX requests
     */
    public function getSpmbStatistics()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
        
        $statistics = [
            'menunggu' => Spmb::where('status_pendaftaran', 'Menunggu Verifikasi')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count(),
            'diterima' => Spmb::where('status_pendaftaran', 'Lulus')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count(),
            'ditolak' => Spmb::where('status_pendaftaran', 'Tidak Lulus')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count(),
            'total' => Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count(),
        ];
        
        return response()->json($statistics);
    }
    
    /**
     * Get recent registrations for AJAX requests
     */
    public function getRecentRegistrations()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
        
        $recent = Spmb::with(['tahunAjaran'])
            ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($spmb) {
                $statusIcon = '';
                $statusColor = '';
                
                switch($spmb->status_pendaftaran) {
                    case 'Lulus':
                        $statusIcon = 'fa-check-circle';
                        $statusColor = 'green';
                        break;
                    case 'Menunggu Verifikasi':
                        $statusIcon = 'fa-clock';
                        $statusColor = 'yellow';
                        break;
                    case 'Tidak Lulus':
                        $statusIcon = 'fa-times-circle';
                        $statusColor = 'red';
                        break;
                    default:
                        $statusIcon = 'fa-question-circle';
                        $statusColor = 'gray';
                }
                
                return [
                    'id' => $spmb->id,
                    'nama' => $spmb->nama_lengkap_anak ?? 'N/A',
                    'no_pendaftaran' => $spmb->no_pendaftaran,
                    'status' => $spmb->status_pendaftaran,
                    'status_icon' => $statusIcon,
                    'status_color' => $statusColor,
                    'tanggal' => $spmb->created_at->format('d/m/Y H:i'),
                    'tanggal_formatted' => $spmb->created_at->diffForHumans(),
                    'url' => route('operator.spmb.show', $spmb->id),
                ];
            });
        
        return response()->json($recent);
    }
}
