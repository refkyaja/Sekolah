<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource (Dashboard Siswa / Pilihan Kategori).
     */
    public function index(Request $request)
    {
        Log::info('SiswaController@index called - Dashboard Siswa');
        
        try {
            // Stats untuk dashboard
            $stats = [
                'total' => Siswa::count(),
                'aktif' => Siswa::aktif()->count(),
                'lulus' => Siswa::lulus()->count(),
                'pindah' => Siswa::pindah()->count(),
                'kelompok_a' => Siswa::where('kelompok', 'A')->count(),
                'kelompok_b' => Siswa::where('kelompok', 'B')->count(),
                'laki_laki' => Siswa::where('jenis_kelamin', 'L')->count(),
                'perempuan' => Siswa::where('jenis_kelamin', 'P')->count(),
            ];

            // Data untuk grafik atau keperluan lain
            $tahunAjarans = TahunAjaran::orderBy('tahun_ajaran', 'desc')->take(5)->get();
            
            return view('admin.siswa.index', compact('stats', 'tahunAjarans'));
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaController@index', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return view('admin.siswa.index')
                ->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }

    /**
     * Display a listing of active students (Siswa Aktif).
     */
    public function indexAktif(Request $request)
    {
        Log::info('SiswaController@indexAktif called');
        
        try {
            $tahunAjarans = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();

            $query = Siswa::with(['tahunAjaran'])->aktif(); // Menggunakan scope aktif dari model
            
            // Filter pencarian
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function($q) use ($search) {
                    $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                      ->orWhere('nik', 'LIKE', "%{$search}%")
                      ->orWhere('nis', 'LIKE', "%{$search}%")
                      ->orWhere('nisn', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter kelompok
            if ($request->filled('kelompok')) {
                $query->where('kelompok', $request->kelompok);
            }

            // Filter tahun ajaran
            if ($request->filled('tahun_ajaran_id')) {
                $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            }
            
            $perPage = $request->get('per_page', 15);
            $siswas = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            // Stats khusus siswa aktif
            $stats = [
                'total' => $siswas->total(),
                'kelompok_a' => Siswa::aktif()->where('kelompok', 'A')->count(),
                'kelompok_b' => Siswa::aktif()->where('kelompok', 'B')->count(),
                'laki_laki' => Siswa::aktif()->where('jenis_kelamin', 'L')->count(),
                'perempuan' => Siswa::aktif()->where('jenis_kelamin', 'P')->count(),
            ];

            // Jika request AJAX, kembalikan JSON untuk partial table
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'table_html' => view('admin.siswa.partials.table', compact('siswas'))->render(),
                    'pagination_html' => $siswas->hasPages() ? $siswas->links('vendor.pagination.tailwind')->render() : '',
                    'stats_html' => view('admin.siswa.siswa-aktif.partials.stats', compact('stats'))->render(),
                    'total' => $stats['total'],
                ]);
            }

            return view('admin.siswa.siswa-aktif.index', compact('siswas', 'stats', 'tahunAjarans'));
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaController@indexAktif', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new active student.
     */
    public function createAktif()
    {
        $kelompok = ['A', 'B'];
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        
        return view('admin.siswa.siswa-aktif.create', compact('kelompok', 'tahunAjaran', 'tahunAjaranAktif'));
    }

    /**
     * Store a newly created active student in storage.
     */
    public function storeAktif(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $validated = $this->validateSiswa($request);
            
            // Set status sebagai aktif
            $validated['status_siswa'] = 'aktif';

            // Handle foto upload
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('siswa/foto', 'public');
                $validated['foto'] = $fotoPath;
            }

            // Set default values
            $validated['punya_wali'] = $request->has('punya_wali');

            Log::info('SiswaController@storeAktif - saving data', $validated);

            $siswa = Siswa::create($validated);

            DB::commit();

            return redirect()->route('admin.siswa.siswa-aktif.show', $siswa)
                ->with('success', 'Data siswa aktif berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput()->with('error', 'Validasi gagal');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@storeAktif', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified active student.
     */
    public function showAktif(Siswa $siswa)
    {
        // Pastikan siswa yang ditampilkan adalah aktif
        if (!$siswa->isAktif()) {
            return redirect()->route('admin.siswa.siswa-aktif.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa aktif.');
        }
        
        $siswa->load(['tahunAjaran', 'spmb']);
        
        return view('admin.siswa.siswa-aktif.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified active student.
     */
    public function editAktif(Siswa $siswa)
    {
        // Pastikan siswa yang diedit adalah aktif
        if (!$siswa->isAktif()) {
            return redirect()->route('admin.siswa.siswa-aktif.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa aktif.');
        }
        
        $kelompok = ['A', 'B'];
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        return view('admin.siswa.siswa-aktif.edit', compact('siswa', 'kelompok', 'tahunAjaran'));
    }

    /**
     * Update the specified active student in storage.
     */
    public function updateAktif(Request $request, Siswa $siswa)
    {
        // Pastikan siswa yang diupdate adalah aktif
        if (!$siswa->isAktif()) {
            return redirect()->route('admin.siswa.siswa-aktif.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa aktif.');
        }
        
        DB::beginTransaction();
        
        try {
            $validated = $this->validateSiswa($request, $siswa->id);

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                
                $fotoPath = $request->file('foto')->store('siswa/foto', 'public');
                $validated['foto'] = $fotoPath;
            }

            // Set boolean values
            $validated['punya_wali'] = $request->has('punya_wali');

            Log::info('SiswaController@updateAktif - updating data', $validated);

            $siswa->update($validated);

            DB::commit();

            return redirect()->route('admin.siswa.siswa-aktif.show', $siswa)
                ->with('success', 'Data siswa aktif berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput()->with('error', 'Validasi gagal');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@updateAktif', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified active student from storage.
     */
    public function destroyAktif(Siswa $siswa)
    {
        // Pastikan siswa yang dihapus adalah aktif
        if (!$siswa->isAktif()) {
            return redirect()->route('admin.siswa.siswa-aktif.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa aktif.');
        }
        
        DB::beginTransaction();
        
        try {
            // Hapus foto jika ada
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // Hapus data siswa
            $siswa->delete();

            DB::commit();

            return redirect()->route('admin.siswa.siswa-aktif.index')
                ->with('success', 'Data siswa aktif berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@destroyAktif', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of graduated students (Siswa Lulus).
     */
    public function indexLulus(Request $request)
    {
        Log::info('SiswaController@indexLulus called');
        
        try {
            $tahunAjarans = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();

            $query = Siswa::with(['tahunAjaran'])->lulus(); // Menggunakan scope lulus dari model
            
            // Filter pencarian
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function($q) use ($search) {
                    $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                      ->orWhere('nik', 'LIKE', "%{$search}%")
                      ->orWhere('nis', 'LIKE', "%{$search}%")
                      ->orWhere('nisn', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter tahun kelulusan
            if ($request->filled('tahun_lulus')) {
                $query->whereYear('tanggal_keluar', $request->tahun_lulus);
            }
            
            $perPage = $request->get('per_page', 15);
            $siswas = $query->orderBy('tanggal_keluar', 'desc')->paginate($perPage);
            
            // Stats khusus siswa lulus
            $stats = [
                'total' => $siswas->total(),
                'tahun_ini' => Siswa::lulus()->whereYear('tanggal_keluar', date('Y'))->count(),
                'tahun_lalu' => Siswa::lulus()->whereYear('tanggal_keluar', date('Y') - 1)->count(),
            ];

            // Jika request AJAX, kembalikan JSON untuk partial table
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'table_html' => view('admin.siswa.partials.table', compact('siswas'))->render(),
                    'pagination_html' => $siswas->hasPages() ? $siswas->links('vendor.pagination.tailwind')->render() : '',
                    'stats_html' => view('admin.siswa.siswa-lulus.partials.stats', compact('stats'))->render(),
                    'total' => $stats['total'],
                ]);
            }

            return view('admin.siswa.siswa-lulus.index', compact('siswas', 'stats', 'tahunAjarans'));
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaController@indexLulus', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified graduated student.
     */
    public function showLulus(Siswa $siswa)
    {
        // Pastikan siswa yang ditampilkan adalah lulus
        if (!$siswa->isLulus()) {
            return redirect()->route('admin.siswa.siswa-lulus.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa lulus.');
        }
        
        $siswa->load(['tahunAjaran', 'spmb']);
        
        return view('admin.siswa.siswa-lulus.show', compact('siswa'));
    }

    /**
     * Show the form for creating a new graduated student.
     */
    public function createLulus()
    {
        $kelompok = ['A', 'B'];
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        return view('admin.siswa.siswa-lulus.create', compact('kelompok', 'tahunAjaran'));
    }

    /**
     * Store a newly created graduated student in storage.
     */
    public function storeLulus(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $validated = $this->validateSiswa($request);
            
            // Set status sebagai lulus dan tanggal keluar
            $validated['status_siswa'] = 'lulus';
            $validated['tanggal_keluar'] = $validated['tanggal_keluar'] ?? now();

            // Handle foto upload
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('siswa/foto', 'public');
                $validated['foto'] = $fotoPath;
            }

            // Set default values
            $validated['punya_wali'] = $request->has('punya_wali');

            Log::info('SiswaController@storeLulus - saving data', $validated);

            $siswa = Siswa::create($validated);

            DB::commit();

            return redirect()->route('admin.siswa.siswa-lulus.show', $siswa)
                ->with('success', 'Data siswa lulus berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput()->with('error', 'Validasi gagal');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@storeLulus', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified graduated student.
     */
    public function editLulus(Siswa $siswa)
    {
        // Pastikan siswa yang diedit adalah lulus
        if (!$siswa->isLulus()) {
            return redirect()->route('admin.siswa.siswa-lulus.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa lulus.');
        }
        
        $kelompok = ['A', 'B'];
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        return view('admin.siswa.siswa-lulus.edit', compact('siswa', 'kelompok', 'tahunAjaran'));
    }

    /**
     * Update the specified graduated student in storage.
     */
    public function updateLulus(Request $request, Siswa $siswa)
    {
        // Pastikan siswa yang diupdate adalah lulus
        if (!$siswa->isLulus()) {
            return redirect()->route('admin.siswa.siswa-lulus.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa lulus.');
        }
        
        DB::beginTransaction();
        
        try {
            $validated = $this->validateSiswa($request, $siswa->id);

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                
                $fotoPath = $request->file('foto')->store('siswa/foto', 'public');
                $validated['foto'] = $fotoPath;
            }

            // Set boolean values
            $validated['punya_wali'] = $request->has('punya_wali');

            Log::info('SiswaController@updateLulus - updating data', $validated);

            $siswa->update($validated);

            DB::commit();

            return redirect()->route('admin.siswa.siswa-lulus.show', $siswa)
                ->with('success', 'Data siswa lulus berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput()->with('error', 'Validasi gagal');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@updateLulus', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified graduated student from storage.
     */
    public function destroyLulus(Siswa $siswa)
    {
        // Pastikan siswa yang dihapus adalah lulus
        if (!$siswa->isLulus()) {
            return redirect()->route('admin.siswa.siswa-lulus.index')
                ->with('error', 'Siswa tidak ditemukan atau bukan siswa lulus.');
        }
        
        DB::beginTransaction();
        
        try {
            // Hapus foto jika ada
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // Hapus data siswa
            $siswa->delete();

            DB::commit();

            return redirect()->route('admin.siswa.siswa-lulus.index')
                ->with('success', 'Data siswa lulus berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@destroyLulus', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update status of a siswa (patch) - General method
     */
    public function updateStatus(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'status_siswa' => 'required|in:aktif,lulus,pindah,cuti',
            'tanggal_keluar' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            // Update status berdasarkan nilai yang dipilih
            $siswa->status_siswa = $validated['status_siswa'];
            
            if (in_array($validated['status_siswa'], ['lulus', 'pindah'])) {
                $siswa->tanggal_keluar = $validated['tanggal_keluar'] ?? now();
            } else {
                $siswa->tanggal_keluar = null;
            }

            if (!empty($validated['catatan'])) {
                $siswa->catatan = $validated['catatan'];
            }

            $siswa->save();

            DB::commit();

            // Redirect based on new status
            $route = match($siswa->status_siswa) {
                'aktif' => 'admin.siswa.siswa-aktif.show',
                'lulus' => 'admin.siswa.siswa-lulus.show',
                default => 'admin.siswa.index'
            };

            return redirect()->route($route, $siswa)
                ->with('success', 'Status siswa berhasil diperbarui menjadi ' . $siswa->status_label . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@updateStatus', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export data siswa
     */
    public function export(Request $request)
    {
        try {
            $query = Siswa::with(['tahunAjaran']);
            
            if ($request->filled('kelompok')) {
                $query->where('kelompok', $request->kelompok);
            }
            
            if ($request->filled('status')) {
                $query->byStatus($request->status);
            }
            
            if ($request->filled('tahun_ajaran_id')) {
                $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            }
            
            $siswas = $query->orderBy('nama_lengkap')->get();
            
            $filename = 'siswa_export_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            $callback = function() use ($siswas) {
                $file = fopen('php://output', 'w');
                
                // Header CSV
                fputcsv($file, [
                    'NIK', 'NIS', 'NISN', 'Nama Lengkap', 'Nama Panggilan',
                    'Tempat Lahir', 'Tanggal Lahir', 'Usia', 'Jenis Kelamin', 'Agama',
                    'Alamat', 'Provinsi', 'Kota/Kabupaten', 'Kecamatan', 'Kelurahan',
                    'Nama Ayah', 'Pekerjaan Ayah', 'Nama Ibu', 'Pekerjaan Ibu',
                    'No HP Orang Tua', 'Email Orang Tua', 'Kelompok', 'Tahun Ajaran',
                    'Status', 'Tanggal Masuk', 'Tanggal Keluar', 'Jalur Masuk', 'Kelas', 'Guru Kelas',
                ]);
                
                // Data
                foreach ($siswas as $siswa) {
                    fputcsv($file, [
                        $siswa->nik,
                        $siswa->nis ?? '-',
                        $siswa->nisn ?? '-',
                        $siswa->nama_lengkap,
                        $siswa->nama_panggilan ?? '-',
                        $siswa->tempat_lahir,
                        $siswa->tanggal_lahir->format('d/m/Y'),
                        $siswa->usia . ' tahun',
                        $siswa->jenis_kelamin_lengkap,
                        $siswa->agama ?? '-',
                        $siswa->alamat,
                        $siswa->provinsi ?? '-',
                        $siswa->kota_kabupaten ?? '-',
                        $siswa->kecamatan ?? '-',
                        $siswa->kelurahan ?? '-',
                        $siswa->nama_ayah,
                        $siswa->pekerjaan_ayah ?? '-',
                        $siswa->nama_ibu,
                        $siswa->pekerjaan_ibu ?? '-',
                        $siswa->no_hp_ortu,
                        $siswa->email_ortu ?? '-',
                        'Kelompok ' . $siswa->kelompok,
                        $siswa->tahunAjaran->tahun_ajaran ?? $siswa->tahun_ajaran,
                        $siswa->status_label,
                        $siswa->tanggal_masuk->format('d/m/Y'),
                        $siswa->tanggal_keluar ? $siswa->tanggal_keluar->format('d/m/Y') : '-',
                        $siswa->jalur_masuk ?? '-',
                        $siswa->kelas ?? '-',
                        $siswa->guru_kelas ?? '-',
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Error in SiswaController@export', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update status siswa
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:siswas,id',
            'status_siswa' => 'required|in:aktif,lulus,pindah,cuti',
            'tanggal_keluar' => 'nullable|date',
        ]);

        DB::beginTransaction();
        
        try {
            $siswas = Siswa::whereIn('id', $validated['ids'])->get();
            $count = 0;
            
            foreach ($siswas as $siswa) {
                $siswa->status_siswa = $validated['status_siswa'];
                
                if (in_array($validated['status_siswa'], ['lulus', 'pindah'])) {
                    $siswa->tanggal_keluar = $validated['tanggal_keluar'] ?? now();
                } else {
                    $siswa->tanggal_keluar = null;
                }
                
                $siswa->save();
                $count++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status ' . $count . ' siswa berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SiswaController@bulkUpdateStatus', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validation method untuk menghindari duplikasi kode
     */
    private function validateSiswa(Request $request, $id = null)
    {
        $rules = [
            // Data siswa
            'nik' => 'required|digits:16|unique:siswas,nik' . ($id ? ',' . $id : ''),
            'nis' => 'nullable|string|max:50|unique:siswas,nis' . ($id ? ',' . $id : ''),
            'nisn' => 'nullable|string|max:50|unique:siswas,nisn' . ($id ? ',' . $id : ''),
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|in:Islam,Kristen Protestan,Kristen Katolik,Hindu,Buddha,Konghucu,Lainnya',
            
            // Alamat
            'alamat' => 'required|string',
            'provinsi' => 'nullable|string|max:100',
            'kota_kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'nama_jalan' => 'nullable|string|max:255',
            
            // Data kesehatan
            'berat_badan' => 'nullable|numeric|min:0|max:200',
            'tinggi_badan' => 'nullable|numeric|min:0|max:200',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'penyakit_pernah_diderita' => 'nullable|string',
            'imunisasi' => 'nullable|string',
            
            // Data ayah
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'nullable|digits:16',
            'tempat_lahir_ayah' => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'bidang_pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'email_ayah' => 'nullable|email|max:255',
            
            // Data ibu
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'nullable|digits:16',
            'tempat_lahir_ibu' => 'nullable|string|max:100',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'bidang_pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:20',
            'email_ibu' => 'nullable|email|max:255',
            
            // Data wali
            'punya_wali' => 'nullable|boolean',
            'nama_wali' => 'nullable|required_if:punya_wali,1|string|max:255',
            'hubungan_wali' => 'nullable|required_if:punya_wali,1|string|max:100',
            'nik_wali' => 'nullable|digits:16',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'nomor_telepon_wali' => 'nullable|string|max:20',
            
            // Kontak
            'no_hp_ortu' => 'required|string|max:20',
            'email_ortu' => 'nullable|email|max:255',
            
            // Informasi akademik
            'kelompok' => 'required|in:A,B',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'tahun_ajaran' => 'required|string|max:9',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'jalur_masuk' => 'nullable|in:zonasi,afirmasi,prestasi,mutasi,reguler',
            
            // Kelas
            'kelas' => 'nullable|string|max:50',
            'guru_kelas' => 'nullable|string|max:255',
            
            // Catatan
            'catatan' => 'nullable|string',
            
            // Foto
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ];

        return $request->validate($rules);
    }

    /**
     * METHODS UNTUK SISWA UMUM (YANG LAMA)
     * Tetap dipertahankan untuk kompatibilitas
     */
    
    public function create()
    {
        return redirect()->route('admin.siswa.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.siswa.index');
    }

    public function show(Siswa $siswa)
    {
        // Redirect ke halaman yang sesuai berdasarkan status
        if ($siswa->isAktif()) {
            return redirect()->route('admin.siswa.siswa-aktif.show', $siswa);
        } elseif ($siswa->isLulus()) {
            return redirect()->route('admin.siswa.siswa-lulus.show', $siswa);
        }
        
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        // Redirect ke halaman yang sesuai berdasarkan status
        if ($siswa->isAktif()) {
            return redirect()->route('admin.siswa.siswa-aktif.edit', $siswa);
        } elseif ($siswa->isLulus()) {
            return redirect()->route('admin.siswa.siswa-lulus.edit', $siswa);
        }
        
        return redirect()->route('admin.siswa.index');
    }

    public function update(Request $request, Siswa $siswa)
    {
        return redirect()->route('admin.siswa.index');
    }

    public function destroy(Siswa $siswa)
    {
        return redirect()->route('admin.siswa.index');
    }
}