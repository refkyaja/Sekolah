<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\User;
use App\Models\Spmb;
use App\Models\TahunAjaran;
use App\Models\BukuTamu;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache tahun ajaran aktif (60 detik)
        $tahunAjaranAktif = Cache::remember('tahun_ajaran_aktif', 60, function () {
            return TahunAjaran::where('is_aktif', true)->first();
        });
        $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
        
        // Cache statistik siswa (60 detik)
        $siswaStatistics = Cache::remember('dashboard_siswa_stats', 60, function () use ($tahunAjaranId) {
            // Total siswa aktif
            $total_siswa = Siswa::aktif()->count();
            
            // Statistik lengkap siswa dalam 1 query
            $siswaStats = Siswa::select(
                DB::raw("COUNT(*) as total_siswa"),
                DB::raw("SUM(CASE WHEN status_siswa = 'lulus' THEN 1 ELSE 0 END) as siswa_lulus"),
                DB::raw("SUM(CASE WHEN deleted_at IS NULL AND status_siswa = 'Aktif' THEN 1 ELSE 0 END) as siswa_aktif"),
                DB::raw("SUM(CASE WHEN deleted_at IS NULL AND kelompok = 'A' THEN 1 ELSE 0 END) as kelompok_a"),
                DB::raw("SUM(CASE WHEN deleted_at IS NULL AND kelompok = 'B' THEN 1 ELSE 0 END) as kelompok_b"),
                DB::raw("SUM(CASE WHEN deleted_at IS NULL AND (status_siswa = 'Aktif' OR status_siswa = 'lulus') AND jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END) as laki_laki"),
                DB::raw("SUM(CASE WHEN deleted_at IS NULL AND (status_siswa = 'Aktif' OR status_siswa = 'lulus') AND jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END) as perempuan")
            )->first();
            
            // Chart siswa per kelompok
            $chart_siswa = Siswa::aktif()
                ->select('kelompok', DB::raw('count(*) as total'))
                ->groupBy('kelompok')
                ->get();
            
            // Siswa per kelompok (duplicate dari chart_siswa, bisa digabung)
            $siswa_per_kelompok = $chart_siswa;
            
            // 5 siswa terbaru
            $siswa_terbaru = Siswa::with(['spmb'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            return [
                'total_siswa' => $total_siswa,
                'siswa_stats' => $siswaStats,
                'chart_siswa' => $chart_siswa,
                'siswa_per_kelompok' => $siswa_per_kelompok,
                'siswa_terbaru' => $siswa_terbaru,
            ];
        });
        
        // Cache statistik SPMB (60 detik)
        $spmbStatistics = Cache::remember('dashboard_spmb_stats', 60, function () use ($tahunAjaranId) {
            // Query tunggal untuk semua statistik SPMB
            $spmbStats = Spmb::select(
                DB::raw("SUM(CASE WHEN status_pendaftaran = 'Menunggu Verifikasi' THEN 1 ELSE 0 END) as menunggu"),
                DB::raw("SUM(CASE WHEN status_pendaftaran = 'Lulus' THEN 1 ELSE 0 END) as diterima"),
                DB::raw("SUM(CASE WHEN status_pendaftaran = 'Tidak Lulus' THEN 1 ELSE 0 END) as mundur"),
                DB::raw("COUNT(*) as total")
            )
            ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->first();
            
            $spmb_statistics = [
                'menunggu' => $spmbStats->menunggu ?? 0,
                'diterima' => $spmbStats->diterima ?? 0,
                'mundur' => $spmbStats->mundur ?? 0,
                'total' => $spmbStats->total ?? 0,
            ];
            
            // Pendaftaran baru (menunggu verifikasi)
            $pendaftaran_baru = $spmb_statistics['menunggu'];
            
            // Recent pendaftaran (5 terbaru)
            $recent_pendaftaran = Spmb::with(['tahunAjaran'])
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // Statistik per jenis daftar
            $jenis_daftar_statistics = Spmb::select('jenis_daftar', DB::raw('count(*) as total'))
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->groupBy('jenis_daftar')
                ->get();
            
            // Statistik per jenis kelamin
            $jk_statistics = Spmb::select('jenis_kelamin', DB::raw('count(*) as total'))
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->groupBy('jenis_kelamin')
                ->get();
            
            // Grafik pendaftaran per bulan
            $grafik_bulanan = Spmb::select(
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();
            
            return [
                'spmb_statistics' => $spmb_statistics,
                'pendaftaran_baru' => $pendaftaran_baru,
                'recent_pendaftaran' => $recent_pendaftaran,
                'jenis_daftar_statistics' => $jenis_daftar_statistics,
                'jk_statistics' => $jk_statistics,
                'grafik_bulanan' => $grafik_bulanan,
            ];
        });
        
        // Cache statistik guru dan admin (60 detik)
        $userStatistics = Cache::remember('dashboard_user_stats', 60, function () {
            return [
                'total_guru' => Guru::count(),
                'total_admin' => User::where('role', 'admin')->count(),
            ];
        });
        
        // Cache statistik absensi (30 detik - lebih sering update)
        $absensiStatistics = Cache::remember('dashboard_absensi_stats', 30, function () use ($siswaStatistics) {
            $absensi_hari_ini = Absensi::whereDate('tanggal', today())->count();
            $total_siswa = $siswaStatistics['total_siswa'];
            $persen_absen = $total_siswa > 0
                ? round(min(100, ($absensi_hari_ini / $total_siswa) * 100), 1)
                : 0;
            
            return [
                'absensi_hari_ini' => $absensi_hari_ini,
                'persen_absen' => $persen_absen,
            ];
        });
        
        // Extract data dari cache
        $total_siswa = $siswaStatistics['total_siswa'];
        $siswaStats = $siswaStatistics['siswa_stats'];
        $chart_siswa = $siswaStatistics['chart_siswa'];
        $siswa_per_kelompok = $siswaStatistics['siswa_per_kelompok'];
        $siswa_terbaru = $siswaStatistics['siswa_terbaru'];
        
        $spmb_statistics = $spmbStatistics['spmb_statistics'];
        $pendaftaran_baru = $spmbStatistics['pendaftaran_baru'];
        $recent_pendaftaran = $spmbStatistics['recent_pendaftaran'];
        $jenis_daftar_statistics = $spmbStatistics['jenis_daftar_statistics'];
        $jk_statistics = $spmbStatistics['jk_statistics'];
        $grafik_bulanan = $spmbStatistics['grafik_bulanan'];
        
        $total_guru = $userStatistics['total_guru'];
        $total_admin = $userStatistics['total_admin'];
        
        $absensi_hari_ini = $absensiStatistics['absensi_hari_ini'];
        $persen_absen = $absensiStatistics['persen_absen'];

        $stats = [
            'siswa_aktif' => $siswaStats->siswa_aktif ?? 0,
            'siswa_lulus' => $siswaStats->siswa_lulus ?? 0,
            'total_siswa' => $total_siswa,
            'total_guru' => $total_guru,
            'total_admin' => $total_admin,
            'pendaftaran_baru' => $pendaftaran_baru,
            'kelompok_a' => $siswaStats->kelompok_a ?? 0,
            'kelompok_b' => $siswaStats->kelompok_b ?? 0,
            'laki_laki' => $siswaStats->laki_laki ?? 0,
            'perempuan' => $siswaStats->perempuan ?? 0,
            'spmb_menunggu' => $spmb_statistics['menunggu'] ?? 0,
            'spmb_diterima' => $spmb_statistics['diterima'] ?? 0,
            'spmb_mundur' => $spmb_statistics['mundur'] ?? 0,
            'ppdb_total' => $spmb_statistics['total'] ?? 0,
            'absensi_hari_ini' => $absensi_hari_ini,
            'persen_absen' => $persen_absen,
        ];

        return view('admin.dashboard', compact(
            'total_siswa',
            'total_guru',
            'total_admin',
            'pendaftaran_baru',
            'recent_pendaftaran',
            'chart_siswa',
            'spmb_statistics',
            'jenis_daftar_statistics',
            'jk_statistics',
            'grafik_bulanan',
            'siswa_per_kelompok',
            'siswa_terbaru',
            'tahunAjaranAktif',
            'stats'
        ));
    }
    
    public function getSpmbStatistics()
    {
        // Cache statistik SPMB untuk API (60 detik)
        $statistics = Cache::remember('api_spmb_stats', 60, function () {
            // Gunakan cache yang sama dengan dashboard
            $tahunAjaranAktif = Cache::remember('tahun_ajaran_aktif', 60, function () {
                return TahunAjaran::where('is_aktif', true)->first();
            });
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            
            // Query tunggal untuk semua statistik
            $spmbStats = Spmb::select(
                DB::raw("SUM(CASE WHEN status_pendaftaran = 'Menunggu Verifikasi' THEN 1 ELSE 0 END) as menunggu"),
                DB::raw("SUM(CASE WHEN status_pendaftaran = 'Lulus' THEN 1 ELSE 0 END) as diterima"),
                DB::raw("SUM(CASE WHEN status_pendaftaran = 'Tidak Lulus' THEN 1 ELSE 0 END) as mundur"),
                DB::raw("COUNT(*) as total")
            )
            ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
            ->first();
            
            return [
                'menunggu' => $spmbStats->menunggu ?? 0,
                'diterima' => $spmbStats->diterima ?? 0,
                'mundur' => $spmbStats->mundur ?? 0,
                'total' => $spmbStats->total ?? 0,
            ];
        });
        
        return response()->json($statistics);
    }
    
    public function getRecentRegistrations()
    {
        // Cache recent registrations (30 detik - lebih sering update)
        $recent = Cache::remember('api_recent_registrations', 30, function () {
            // Gunakan cache tahun ajaran yang sudah ada
            $tahunAjaranAktif = Cache::remember('tahun_ajaran_aktif', 60, function () {
                return TahunAjaran::where('is_aktif', true)->first();
            });
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            
            return Spmb::with(['tahunAjaran'])
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
                        'url' => route('admin.spmb.show', $spmb->id),
                    ];
                });
        });
        
        return response()->json($recent);
    }

    /**
     * Get Buku Tamu Statistics
     * Perbaikan: Menggunakan cache untuk optimasi
     */
    public function getBukuTamuStatistics()
    {
        // Cache statistik buku tamu (60 detik)
        $stats = Cache::remember('api_buku_tamu_stats', 60, function () {
            try {
                return [
                    'total' => BukuTamu::count(),
                    'today' => BukuTamu::whereDate('created_at', today())->count(),
                    'pending' => BukuTamu::where('status_pendaftaran', 'pending')->count(),
                    'verified' => BukuTamu::where('is_verified', true)->count(),
                ];
            } catch (\Exception $e) {
                // Jika terjadi error, kembalikan data default
                return [
                    'total' => 0,
                    'today' => 0,
                    'pending' => 0,
                    'verified' => 0,
                ];
            }
        });
        
        return response()->json($stats);
    }
    
    /**
     * Get SPMB statistics by year
     */
    public function getSpmbStatisticsByYear($year = null)
    {
        $year = $year ?? date('Y');
        
        // Cache statistik per tahun (300 detik - 5 menit)
        $statistics = Cache::remember("api_spmb_stats_year_{$year}", 300, function () use ($year) {
            return Spmb::select(
                    'status_pendaftaran',
                    DB::raw('count(*) as total')
                )
                ->whereYear('created_at', $year)
                ->groupBy('status_pendaftaran')
                ->get();
        });
        
        return response()->json($statistics);
    }
    
    /**
     * Get recent konversi ke siswa
     */
    public function getRecentKonversi()
    {
        // Cache recent konversi (60 detik)
        $recent = Cache::remember('api_recent_konversi', 60, function () {
            return Siswa::with(['spmb'])
                ->whereNotNull('spmb_id')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($siswa) {
                    return [
                        'nama' => $siswa->nama_lengkap,
                        'kelompok' => $siswa->kelompok,
                        'tanggal' => $siswa->created_at->format('d/m/Y H:i'),
                        'url' => route('admin.siswa.show', $siswa->id)
                    ];
                });
        });
        
        return response()->json($recent);
    }

    /**
     * Method untuk membersihkan cache dashboard
     * Bisa dipanggil manual saat ada perubahan data
     */
    public function clearDashboardCache()
    {
        $cacheKeys = [
            'tahun_ajaran_aktif',
            'dashboard_siswa_stats',
            'dashboard_spmb_stats',
            'dashboard_user_stats',
            'dashboard_absensi_stats',
            'api_spmb_stats',
            'api_recent_registrations',
            'api_buku_tamu_stats',
            'api_recent_konversi',
        ];
        
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
        
        // Hapus cache per tahun jika ada
        for ($year = date('Y') - 2; $year <= date('Y') + 1; $year++) {
            Cache::forget("api_spmb_stats_year_{$year}");
        }
        
        return response()->json([
            'message' => 'Dashboard cache cleared successfully',
            'cleared_keys' => $cacheKeys
        ]);
    }

    /**
     * Optional: Method untuk mengecek struktur tabel buku_tamu
     * Bisa dipanggil sementara untuk debugging
     */
    public function checkBukuTamuStructure()
    {
        try {
            $columns = \Schema::getColumnListing('buku_tamus');
            return response()->json([
                'columns' => $columns,
                'sample' => BukuTamu::first()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}