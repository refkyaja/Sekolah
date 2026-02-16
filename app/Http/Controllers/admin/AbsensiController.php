<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        try {
            // ===== FIX FILTER: HAPUS RANGE, GANTI DENGAN MODE YANG JELAS =====
            $query = Absensi::with(['siswa', 'guru'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc');

            // FILTER KELOMPOK (bisa kosong = semua)
            if ($request->filled('kelompok')) {
                $query->whereHas('siswa', function($q) use ($request) {
                    $q->where('kelompok', $request->kelompok);
                });
            }

            // FILTER TANGGAL: Lebih jelas pilihannya
            if ($request->filled('tanggal')) {
                // Tanggal spesifik
                $query->whereDate('tanggal', $request->tanggal);
            } elseif ($request->filled('bulan')) {
                // Filter per bulan
                $query->whereYear('tanggal', Carbon::parse($request->bulan)->year)
                    ->whereMonth('tanggal', Carbon::parse($request->bulan)->month);
            }
            // Kalo ga pilih filter tanggal, tampilkan semua (default)

            $absensi = $query->paginate(20)->withQueryString();
            
            // ===== STATISTIK YANG RELEVAN =====
            // Jangan pake "hari ini" terus, sesuaikan dengan filter
            if ($request->filled('tanggal')) {
                // Statistik untuk tanggal tertentu
                $statistik_tanggal = [
                    'hadir' => Absensi::whereDate('tanggal', $request->tanggal)->where('status', 'hadir')->count(),
                    'izin' => Absensi::whereDate('tanggal', $request->tanggal)->where('status', 'izin')->count(),
                    'sakit' => Absensi::whereDate('tanggal', $request->tanggal)->where('status', 'sakit')->count(),
                    'tidak_hadir' => Absensi::whereDate('tanggal', $request->tanggal)->where('status', 'tidak_hadir')->count(),
                ];
            } else {
                // Statistik global
                $statistik_tanggal = null;
            }

            // Statistik umum (selalu ada)
            $total_absensi = Absensi::count();
            $total_hadir = Absensi::where('status', 'hadir')->count();
            $total_izin_sakit = Absensi::whereIn('status', ['izin', 'sakit'])->count();
            $total_tidak_hadir = Absensi::where('status', 'tidak_hadir')->count();
            
            $persen_hadir = $total_absensi > 0 
                ? round(($total_hadir / $total_absensi) * 100, 1) 
                : 0;

            // ===== DATA GURU PER KELOMPOK =====
            $guru_kelompok_a = Guru::where('kelompok', 'A')->first();
            $guru_kelompok_b = Guru::where('kelompok', 'B')->first();

            // Chart 7 hari terakhir
            $sevenDaysAgo = Carbon::today()->subDays(7);
            $chart_7_hari = Absensi::select(
                    DB::raw('DATE(tanggal) as tanggal'),
                    DB::raw('COUNT(CASE WHEN status = "hadir" THEN 1 END) as hadir'),
                    DB::raw('COUNT(CASE WHEN status = "tidak_hadir" THEN 1 END) as tidak_hadir')
                )
                ->where('tanggal', '>=', $sevenDaysAgo)
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('tanggal')
                ->get()
                ->map(function($item) {
                    $item->tanggal = Carbon::parse($item->tanggal)->format('d/m');
                    return $item;
                });

            // Status distribution
            $status_distribution = [
                Absensi::where('status', 'hadir')->count(),
                Absensi::where('status', 'izin')->count(),
                Absensi::where('status', 'sakit')->count(),
                Absensi::where('status', 'tidak_hadir')->count(),
            ];

            // Data untuk view
            $data = [
                'absensi' => $absensi,
                'total_absensi' => $total_absensi,
                'total_hadir' => $total_hadir,
                'total_izin_sakit' => $total_izin_sakit,
                'total_tidak_hadir' => $total_tidak_hadir,
                'persen_hadir' => $persen_hadir,
                'chart_7_hari' => $chart_7_hari,
                'status_distribution' => $status_distribution,
                'guru_kelompok_a' => $guru_kelompok_a,
                'guru_kelompok_b' => $guru_kelompok_b,
                'statistik_tanggal' => $statistik_tanggal,
                'pendaftaran_baru' => 0 // atau ambil dari model Spmb
            ];

            return view('admin.absensi.index', $data);
            
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@index: ' . $e->getMessage());
            
            return view('admin.absensi.index', [
                'absensi' => collect(),
                'total_absensi' => 0,
                'total_hadir' => 0,
                'total_izin_sakit' => 0,
                'total_tidak_hadir' => 0,
                'persen_hadir' => 0,
                'chart_7_hari' => collect(),
                'status_distribution' => [0,0,0,0],
                'guru_kelompok_a' => null,
                'guru_kelompok_b' => null,
                'statistik_tanggal' => null,
                'pendaftaran_baru' => 0
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $absensi = Absensi::with(['siswa', 'guru'])->findOrFail($id);
            
            // KIRIM JUGA DAFTAR GURU PER KELOMPOK
            $guru_list = [];
            if ($absensi->siswa && $absensi->siswa->kelompok) {
                $guru_list = Guru::where('kelompok', $absensi->siswa->kelompok)->get();
            }
            
            return response()->json([
                'success' => true,
                'siswa_nama' => $absensi->siswa->nama_lengkap ?? $absensi->siswa->nama ?? 'Tidak ditemukan',
                'tanggal' => $absensi->tanggal,
                'status' => $absensi->status,
                'keterangan' => $absensi->keterangan,
                'guru_id' => $absensi->guru_id,
                'guru_list' => $guru_list // TAMBAHKAN INI
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@edit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,tidak_hadir',
            'keterangan' => 'nullable|string|max:255'
        ]);

        try {
            $absensi = Absensi::findOrFail($id);
            $absensi->update([
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'keterangan' => $request->keterangan
            ]);

            return redirect()->route('admin.absensi.index')
                ->with('success', 'Data absensi berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@update: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $absensi = Absensi::findOrFail($id);
            $absensi->delete();

            return redirect()->route('admin.absensi.index')
                ->with('success', 'Data absensi berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:absensi,id'
            ]);

            Absensi::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' data absensi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@bulkDelete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the bulk input (fill) form that lists students for a chosen date/kelompok
     */
    public function fill(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));
        $kelompok = $request->get('kelompok', '');

        // Ambil siswa berdasarkan kelompok
        $query = Siswa::query()->orderBy('nama_lengkap');
        if (!empty($kelompok)) {
            $query->where('kelompok', $kelompok);
        }
        $siswa = $query->get();

        // AMBIL GURU YANG SESUAI KELOMPOK
        $guru = null;
        if (!empty($kelompok)) {
            $guru = Guru::where('kelompok', $kelompok)->first();
        }

        // existing absensi
        $existing = Absensi::whereIn('siswa_id', $siswa->pluck('id'))
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        return view('admin.absensi.fill', compact(
            'siswa', 
            'tanggal', 
            'kelompok', 
            'existing',
            'guru' // <-- KIRIM KE VIEW
        ));
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kelompok' => 'nullable|string',
            'guru_id' => 'nullable|exists:gurus,id', // <-- TAMBAHKAN VALIDASI
            'statuses' => 'required|array',
            'statuses.*' => 'in:hadir,izin,sakit,tidak_hadir,alpa',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $tanggal = $request->tanggal;
            
            // ===== PAKAI GURU_ID DARI FORM, JANGAN DICARI LAGI! =====
            $guruId = $request->guru_id; // LANGSUNG PAKAI DARI FORM
            
            // Fallback: cari berdasarkan kelompok kalau kosong
            if (!$guruId && $request->kelompok) {
                $guru = Guru::where('kelompok', $request->kelompok)->first();
                $guruId = $guru ? $guru->id : null;
            }

            foreach ($request->statuses as $siswaId => $status) {
                if ($status === 'alpa') {
                    $status = 'tidak_hadir';
                }

                $keterangan = $request->keterangan[$siswaId] ?? null;
                
                Absensi::updateOrCreate(
                    ['siswa_id' => $siswaId, 'tanggal' => $tanggal],
                    [
                        'status' => $status, 
                        'keterangan' => $keterangan, 
                        'guru_id' => $guruId  // <-- SEKARANG PASTI BENAR!
                    ]
                );
            }

            DB::commit();

            return redirect()->route('admin.absensi.index')
                ->with('success', 'Absensi berhasil disimpan untuk kelompok ' . $request->kelompok . ' dengan guru ' . ($guru->nama ?? ''));
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in AbsensiController@storeBatch: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $query = Absensi::with(['siswa', 'guru'])
                ->orderBy('tanggal', 'desc');

            if ($request->has('kelompok') && $request->kelompok != '') {
                $query->whereHas('siswa', function($q) use ($request) {
                    $q->where('kelompok', $request->kelompok);
                });
            }

            $absensi = $query->get();

            // Create CSV file
            $filename = 'absensi-siswa-' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($absensi) {
                $file = fopen('php://output', 'w');
                
                // Header CSV
                fputcsv($file, [
                    'No',
                    'Nama Siswa',
                    'Kelompok',
                    'NIS',
                    'Tanggal',
                    'Status',
                    'Keterangan',
                    'Guru Pengajar',
                    'Waktu Input'
                ]);

                // Data CSV
                $no = 1;
                foreach ($absensi as $item) {
                    fputcsv($file, [
                        $no++,
                        $item->siswa->nama ?? 'Tidak ditemukan',
                        $item->siswa->kelompok ?? '-',
                        $item->siswa->nis ?? '-',
                        $item->tanggal,
                        ucfirst(str_replace('_', ' ', $item->status)),
                        $item->keterangan ?? '-',
                        $item->guru->nama ?? '-',
                        $item->created_at->format('d/m/Y H:i')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@export: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    public function rekap(Request $request)
    {
        try {
            // Query untuk rekap
            $query = Absensi::with(['siswa', 'guru'])
                ->orderBy('tanggal', 'desc');

            if ($request->has('kelompok') && $request->kelompok != '') {
                $query->whereHas('siswa', function($q) use ($request) {
                    $q->where('kelompok', $request->kelompok);
                });
            }

            if ($request->has('bulan')) {
                $bulan = Carbon::parse($request->bulan)->format('Y-m');
                $query->whereYear('tanggal', Carbon::parse($request->bulan)->year)
                      ->whereMonth('tanggal', Carbon::parse($request->bulan)->month);
            }

            $rekap_data = $query->paginate(50);

            // Statistik rekap
            $statistik = [
                'total_absensi' => Absensi::count(),
                'hadir' => Absensi::where('status', 'hadir')->count(),
                'izin' => Absensi::where('status', 'izin')->count(),
                'sakit' => Absensi::where('status', 'sakit')->count(),
                'tidak_hadir' => Absensi::where('status', 'tidak_hadir')->count(),
            ];

            return view('admin.absensi.rekap', compact('rekap_data', 'statistik'));
        } catch (\Exception $e) {
            \Log::error('Error in AbsensiController@rekap: ' . $e->getMessage());
            return view('admin.absensi.rekap', [
                'rekap_data' => collect(),
                'statistik' => []
            ])->with('error', 'Gagal memuat data rekap');
        }
    }

    /**
     * API untuk mendapatkan guru berdasarkan kelompok
     * Dipanggil via AJAX dari view
     */
    public function getGuruByKelompok(Request $request)
    {
        $kelompok = $request->kelompok;
        
        if (!$kelompok) {
            return response()->json([]);
        }
        
        $guru = Guru::where('kelompok', $kelompok)->get(['id', 'nama', 'nip']);
        
        return response()->json($guru);
    }
}