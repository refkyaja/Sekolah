<?php
// app/Http/Controllers/Admin/SpmbController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\Siswa;
use App\Models\SpmbArsip;
use App\Models\TahunAjaran;
use App\Models\SpmbDokumen;
use App\Models\SpmbBuktiTransfer;
use App\Models\SpmbRiwayatStatus;
use App\Models\SpmbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class SpmbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Spmb::with(['tahunAjaran', 'siswa']);
            
            $search = $request->get('search', '');
            
            if (!empty($search)) {
                $query->search($search);
            }

            $query->whereNotIn('status_pendaftaran', ['Tidak Lulus']);
            
            if ($request->filled('status_pendaftaran')) {
                $query->byStatus($request->status_pendaftaran);
            }
            
            if ($request->filled('tahun_ajaran_id')) {
                $query->byTahunAjaran($request->tahun_ajaran_id);
            }
            
            if ($request->filled('jenis_kelamin')) {
                $query->byJenisKelamin($request->jenis_kelamin);
            }
            
            // Filter dengan nilai yang sudah konsisten
            if ($request->filled('tinggal_bersama')) {
                $query->byTinggalBersama($request->tinggal_bersama);
            }
            
            if ($request->filled('status_tempat_tinggal')) {
                $query->byStatusTempatTinggal($request->status_tempat_tinggal);
            }
            
            if ($request->filled('pekerjaan_ayah')) {
                $query->byPekerjaanAyah($request->pekerjaan_ayah);
            }
            
            if ($request->filled('pekerjaan_ibu')) {
                $query->byPekerjaanIbu($request->pekerjaan_ibu);
            }
            
            if ($request->filled('punya_saudara_sekolah_tk')) {
                $query->byPunyaSaudaraSekolahTk($request->punya_saudara_sekolah_tk);
            }
            
            $perPage = $request->get('per_page', 15);
            $spmb = $query->latest()->paginate($perPage);
            
            $statistik = Spmb::getStatistik($request->tahun_ajaran_id);
            $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
            
            // ✅ PERBAIKAN: Gunakan konstanta dari model untuk konsistensi
            $tinggalBersamaOptions = Spmb::TINGGAL_BERSAMA_OPTIONS;
            $statusTempatTinggalOptions = Spmb::STATUS_TEMPAT_TINGGAL_OPTIONS;
            $pekerjaanAyahOptions = Spmb::PEKERJAAN_AYAH_OPTIONS;
            $pekerjaanIbuOptions = Spmb::PEKERJAAN_IBU_OPTIONS;
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'table_html' => view('admin.spmb.partials.table', compact('spmb', 'search'))->render(),
                    'pagination_html' => $spmb->hasPages() 
                        ? $spmb->onEachSide(1)->links('vendor.pagination.tailwind')->toHtml() 
                        : '',
                    'stats_html' => view('admin.spmb.partials.stats', compact('statistik'))->render(),
                    'total' => $spmb->total(),
                    'filtered_count' => $spmb->count(),
                    'statistik' => $statistik,
                ]);
            }
            
            return view('admin.ppdb.index', compact(
                'spmb', 
                'search', 
                'statistik', 
                'tahunAjaran',
                'tinggalBersamaOptions',
                'statusTempatTinggalOptions',
                'pekerjaanAyahOptions',
                'pekerjaanIbuOptions'
            ));
            
        } catch (\Exception $e) {
            Log::error('SpmbController@index Error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memuat data.'
                ], 500);
            }
            
            return redirect()->route('admin.spmb.index')
                ->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    /**
     * Show export page.
     */
    public function exportIndex(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        $statistikPerTahun = [];
        foreach ($tahunAjaran as $ta) {
            $statistik = Spmb::getStatistik($ta->id);
            $statistikPerTahun[] = [
                'tahun_ajaran_id' => $ta->id,
                'tahun_ajaran' => $ta->tahun_ajaran,
                'is_active' => $ta->is_aktif,
                'total' => $statistik['total'],
                'lulus' => $statistik['diterima'],
                'tidak_lulus' => $statistik['mundur'],
                'menunggu' => $statistik['menunggu'],
            ];
        }

        return view('admin.ppdb.export', compact('tahunAjaran', 'statistikPerTahun'));
    }

    /**
     * Export data to PDF/Excel.
     */
    public function export(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajarans,id',
            'format' => 'required|in:pdf,excel',
        ]);

        $tahunAjaranId = $request->tahun_ajaran_id;
        $format = $request->format;
        
        $query = Spmb::with(['tahunAjaran']);
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        $data = $query->get();
        $tahunAjaran = $tahunAjaranId ? TahunAjaran::find($tahunAjaranId) : null;

        if ($format === 'pdf') {
            return $this->exportPdf($data, $tahunAjaran);
        } else {
            return $this->exportExcel($data, $tahunAjaran);
        }
    }

    /**
     * Export all data.
     */
    public function exportAll(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
        ]);

        $format = $request->format;
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        $data = Spmb::with(['tahunAjaran'])->get();

        if ($format === 'pdf') {
            return $this->exportPdf($data, null, true);
        } else {
            return $this->exportExcel($data, null, true);
        }
    }

    /**
     * Export to PDF.
     */
    private function exportPdf($data, $tahunAjaran = null, $allData = false)
    {
        // Get tahun ajaran data for each item
        $tahunAjaranList = $allData ? \App\Models\TahunAjaran::orderBy('tahun_ajaran', 'desc')->get() : collect([$tahunAjaran]);
        
        $html = view('admin.ppdb.export-pdf', [
            'data' => $data,
            'tahunAjaran' => $tahunAjaran,
            'allData' => $allData,
            'tahunAjaranList' => $tahunAjaranList,
        ])->render();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape');
        
        $tahunAjaranName = $tahunAjaran ? str_replace('/', '-', $tahunAjaran->tahun_ajaran) : 'semua';
        $filename = 'export_ppdb_' . $tahunAjaranName . '_' . date('Ymd_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export to Excel.
     */
    private function exportExcel($data, $tahunAjaran = null, $allData = false)
    {
        $tahunAjaranName = $tahunAjaran ? str_replace('/', '-', $tahunAjaran->tahun_ajaran) : 'semua';
        $filename = 'export_ppdb_' . $tahunAjaranName . '_' . date('Ymd_His') . '.xlsx';
        
        $exportData = $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'No Pendaftaran' => $item->no_pendaftaran,
                'Nama Lengkap' => $item->nama_lengkap_anak,
                'NIK' => "'" . $item->nik_anak, // Prefix with ' to force text format
                'NISN' => $item->nisn ? "'" . $item->nisn : '-',
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Tempat Lahir' => $item->tempat_lahir_anak,
                'Tanggal Lahir' => $item->tanggal_lahir_anak ? $item->tanggal_lahir_anak->format('d-m-Y') : '-',
                'Nama Ayah' => $item->nama_lengkap_ayah ?? '-',
                'Nama Ibu' => $item->nama_lengkap_ibu ?? '-',
                'No Telepon' => $item->nomor_telepon_ayah ?? $item->nomor_telepon_ibu ?? '-',
                'Status' => $item->status_pendaftaran,
                'Tahun Ajaran' => $item->tahunAjaran?->tahun_ajaran ?? '-',
            ];
        });
        
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SpmbExport($exportData), $filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        // ✅ PERBAIKAN: Gunakan konstanta dari model, HAPUS 'ayah'/'ibu' lowercase
        $tinggalBersamaOptions = Spmb::TINGGAL_BERSAMA_OPTIONS;
        $statusTempatTinggalOptions = Spmb::STATUS_TEMPAT_TINGGAL_OPTIONS;
        $pekerjaanAyahOptions = Spmb::PEKERJAAN_AYAH_OPTIONS;
        $pekerjaanIbuOptions = Spmb::PEKERJAAN_IBU_OPTIONS;
        
        return view('admin.ppdb.create', compact(
            'tahunAjaran', 
            'tahunAjaranAktif',
            'tinggalBersamaOptions',
            'statusTempatTinggalOptions',
            'pekerjaanAyahOptions',
            'pekerjaanIbuOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // ✅ PERBAIKAN KRITIS: Mapping input sebelum validasi
            $this->normalizeTinggalBersamaInput($request);
            
            $validated = $request->validate([
                // Data Anak (Bagian 1)
                'nama_lengkap_anak' => 'required|string|max:255',
                'nama_panggilan_anak' => 'nullable|string|max:100',
                'nik_anak' => 'required|digits:16|unique:spmb,nik_anak',
                'tempat_lahir_anak' => 'required|string|max:100',
                'tanggal_lahir_anak' => 'required|date',
                'provinsi_rumah' => 'required|string|max:100',
                'kota_kabupaten_rumah' => 'required|string|max:100',
                'kecamatan_rumah' => 'required|string|max:100',
                'kelurahan_rumah' => 'required|string|max:100',
                'nama_jalan_rumah' => 'required|string|max:255',
                'alamat_kk_sama' => 'nullable|boolean',
                'alamat_kk' => 'nullable|required_if:alamat_kk_sama,false|string',
                'provinsi_kk' => 'nullable|required_if:alamat_kk_sama,false|string|max:100',
                'kota_kabupaten_kk' => 'nullable|required_if:alamat_kk_sama,false|string|max:100',
                'kecamatan_kk' => 'nullable|required_if:alamat_kk_sama,false|string|max:100',
                'kelurahan_kk' => 'nullable|required_if:alamat_kk_sama,false|string|max:100',
                'nama_jalan_kk' => 'nullable|required_if:alamat_kk_sama,false|string|max:255',
                'jenis_kelamin' => 'required|in:' . implode(',', Spmb::JENIS_KELAMIN_OPTIONS),
                'agama' => 'required|in:' . implode(',', Spmb::AGAMA_OPTIONS),
                'anak_ke' => 'required|integer|min:1',
                // ✅ PERBAIKAN: Validasi tinggal_bersama dengan semua opsi yang valid
                'tinggal_bersama' => 'required|in:' . implode(',', Spmb::TINGGAL_BERSAMA_OPTIONS),
                'status_tempat_tinggal' => 'required|in:' . implode(',', Spmb::STATUS_TEMPAT_TINGGAL_OPTIONS),
                'bahasa_sehari_hari' => 'required|string|max:100',
                'jarak_rumah_ke_sekolah' => 'nullable|integer|min:0',
                'waktu_tempuh_ke_sekolah' => 'nullable|integer|min:0',
                'berat_badan' => 'nullable|numeric|min:0|max:100',
                'tinggi_badan' => 'nullable|numeric|min:0|max:200',
                'golongan_darah' => 'nullable|in:' . implode(',', Spmb::GOLONGAN_DARAH_OPTIONS),
                'penyakit_pernah_diderita' => 'nullable|string',
                'imunisasi_pernah_diterima' => 'nullable|string',
                
                // Data Ayah
                'nama_lengkap_ayah' => 'required|string|max:255',
                'nik_ayah' => 'required|digits:16',
                'tempat_lahir_ayah' => 'required|string|max:100',
                'tanggal_lahir_ayah' => 'required|date',
                'pendidikan_ayah' => 'nullable|string|max:100',
                'pekerjaan_ayah' => 'nullable|in:' . implode(',', Spmb::PEKERJAAN_AYAH_OPTIONS),
                'bidang_pekerjaan_ayah' => 'nullable|string|max:100',
                'penghasilan_per_bulan_ayah' => 'nullable|string|max:100',
                'nomor_telepon_ayah' => 'required|string|regex:/^[0-9]{10,16}$/|max:16',
                'email_ayah' => 'nullable|email|max:255',
                
                // Data Ibu
                'nama_lengkap_ibu' => 'required|string|max:255',
                'nik_ibu' => 'required|digits:16',
                'tempat_lahir_ibu' => 'required|string|max:100',
                'tanggal_lahir_ibu' => 'required|date',
                'pendidikan_ibu' => 'nullable|string|max:100',
                'pekerjaan_ibu' => 'nullable|in:' . implode(',', Spmb::PEKERJAAN_IBU_OPTIONS),
                'bidang_pekerjaan_ibu' => 'nullable|string|max:100',
                'penghasilan_per_bulan_ibu' => 'nullable|string|max:100',
                'nomor_telepon_ibu' => 'required|string|regex:/^[0-9]{10,16}$/|max:16',
                'email_ibu' => 'nullable|email|max:255',
                
                // Data Wali
                'punya_wali' => 'nullable|boolean',
                'nama_lengkap_wali' => 'nullable|required_if:punya_wali,true|string|max:255',
                'hubungan_dengan_anak' => 'nullable|required_if:punya_wali,true|in:' . implode(',', Spmb::HUBUNGAN_WALI_OPTIONS),
                'nik_wali' => 'nullable|required_if:punya_wali,true|digits:16',
                'tempat_lahir_wali' => 'nullable|required_if:punya_wali,true|string|max:100',
                'tanggal_lahir_wali' => 'nullable|required_if:punya_wali,true|date',
                'pendidikan_wali' => 'nullable|string|max:100',
                'pekerjaan_wali' => 'nullable|string|max:100',
                'bidang_pekerjaan_wali' => 'nullable|string|max:100',
                'penghasilan_per_bulan_wali' => 'nullable|string|max:100',
                'nomor_telepon_wali' => 'nullable|string|regex:/^[0-9]{10,16}$/|max:16',
                'email_wali' => 'nullable|email|max:255',
                
                // Informasi Tambahan
                'sumber_informasi_ppdb' => 'nullable|in:' . implode(',', Spmb::SUMBER_INFORMASI_OPTIONS),
                'punya_saudara_sekolah_tk' => 'nullable|in:' . implode(',', Spmb::PUNYA_SAUDARA_SEKOLAH_TK_OPTIONS),
                'jenis_daftar' => 'required|in:' . implode(',', Spmb::JENIS_DAFTAR_OPTIONS),
                
                // Foreign Key
                'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
                
                // Dokumen - required for student registration
                'akte_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'ktp_orang_tua' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ], [
                'akte_kelahiran.required' => 'Dokumen akte kelahiran wajib diupload',
                'kartu_keluarga.required' => 'Dokumen Kartu Keluarga wajib diupload',
                'ktp_orang_tua.required' => 'Dokumen KTP Orang Tua wajib diupload',
            ]);
            
            // Set default values - use active tahun ajaran
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
            $validated['tahun_ajaran_id'] = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            $validated['no_pendaftaran'] = $this->generateNomorPendaftaran();
            $validated['status_pendaftaran'] = 'Menunggu Verifikasi';
            $validated['alamat_kk_sama'] = $request->has('alamat_kk_sama');
            $validated['punya_wali'] = $request->has('punya_wali');
            $validated['punya_saudara_sekolah_tk'] = $request->punya_saudara_sekolah_tk ?? 'Tidak';
            
            // Buat alamat rumah lengkap
            $validated['alamat_rumah'] = $request->nama_jalan_rumah . ', ' . 
                                        $request->kelurahan_rumah . ', ' . 
                                        $request->kecamatan_rumah . ', ' . 
                                        $request->kota_kabupaten_rumah . ', ' . 
                                        $request->provinsi_rumah;
            
            DB::beginTransaction();
            
            // Create SPMB record
            $spmb = Spmb::create($validated);
            
            // Handle dokumen uploads
            $this->handleDokumenUploads($request, $spmb);
            
            // Catat riwayat status awal
            $spmb->riwayatStatus()->create([
                'status_sebelumnya' => null,
                'status_baru' => 'Menunggu Verifikasi',
                'keterangan' => 'Pendaftaran baru dibuat oleh admin',
                'diubah_oleh' => auth()->id(),
                'role_pengubah' => auth()->user()->role ?? 'admin'
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.spmb.show', $spmb)
                ->with('success', 'Data pendaftaran SPMB berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SpmbController@store Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan data pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Spmb $spmb)
    {
        $spmb->load(['tahunAjaran', 'dokumen', 'buktiTransfer', 'riwayatStatus.user', 'siswa']);
        
        return view('admin.ppdb.show', compact('spmb'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spmb $spmb)
    {
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        
        // ✅ PERBAIKAN: Gunakan konstanta dari model
        $tinggalBersamaOptions = Spmb::TINGGAL_BERSAMA_OPTIONS;
        $statusTempatTinggalOptions = Spmb::STATUS_TEMPAT_TINGGAL_OPTIONS;
        $pekerjaanAyahOptions = Spmb::PEKERJAAN_AYAH_OPTIONS;
        $pekerjaanIbuOptions = Spmb::PEKERJAAN_IBU_OPTIONS;
        
        return view('admin.ppdb.edit', compact(
            'spmb', 
            'tahunAjaran',
            'tinggalBersamaOptions',
            'statusTempatTinggalOptions',
            'pekerjaanAyahOptions',
            'pekerjaanIbuOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spmb $spmb)
    {
        try {
            // ✅ PERBAIKAN KRITIS: Mapping input sebelum validasi
            $this->normalizeTinggalBersamaInput($request);
            
            $validated = $request->validate([
                // Data Anak (Bagian 1)
                'nama_lengkap_anak' => 'required|string|max:255',
                'nama_panggilan_anak' => 'nullable|string|max:100',
                'nik_anak' => 'required|digits:16|unique:spmb,nik_anak,' . $spmb->id,
                'tempat_lahir_anak' => 'required|string|max:100',
                'tanggal_lahir_anak' => 'required|date',
                'provinsi_rumah' => 'required|string|max:100',
                'kota_kabupaten_rumah' => 'required|string|max:100',
                'kecamatan_rumah' => 'required|string|max:100',
                'kelurahan_rumah' => 'required|string|max:100',
                'nama_jalan_rumah' => 'required|string|max:255',
                'alamat_kk_sama' => 'nullable|boolean',
                'alamat_kk' => 'nullable|string',
                'provinsi_kk' => 'nullable|string|max:100',
                'kota_kabupaten_kk' => 'nullable|string|max:100',
                'kecamatan_kk' => 'nullable|string|max:100',
                'kelurahan_kk' => 'nullable|string|max:100',
                'nama_jalan_kk' => 'nullable|string|max:255',
                'jenis_kelamin' => 'required|in:' . implode(',', Spmb::JENIS_KELAMIN_OPTIONS),
                'agama' => 'required|in:' . implode(',', Spmb::AGAMA_OPTIONS),
                'anak_ke' => 'required|integer|min:1',
                // ✅ PERBAIKAN: Validasi tinggal_bersama dengan semua opsi yang valid
                'tinggal_bersama' => 'required|in:' . implode(',', Spmb::TINGGAL_BERSAMA_OPTIONS),
                'status_tempat_tinggal' => 'required|in:' . implode(',', Spmb::STATUS_TEMPAT_TINGGAL_OPTIONS),
                'bahasa_sehari_hari' => 'required|string|max:100',
                'jarak_rumah_ke_sekolah' => 'nullable|integer|min:0',
                'waktu_tempuh_ke_sekolah' => 'nullable|integer|min:0',
                'berat_badan' => 'nullable|numeric|min:0|max:100',
                'tinggi_badan' => 'nullable|numeric|min:0|max:200',
                'golongan_darah' => 'nullable|in:' . implode(',', Spmb::GOLONGAN_DARAH_OPTIONS),
                'penyakit_pernah_diderita' => 'nullable|string',
                'imunisasi_pernah_diterima' => 'nullable|string',
                
                // Data Ayah
                'nama_lengkap_ayah' => 'required|string|max:255',
                'nik_ayah' => 'required|digits:16',
                'tempat_lahir_ayah' => 'required|string|max:100',
                'tanggal_lahir_ayah' => 'required|date',
                'pendidikan_ayah' => 'nullable|string|max:100',
                'pekerjaan_ayah' => 'nullable|in:' . implode(',', Spmb::PEKERJAAN_AYAH_OPTIONS),
                'bidang_pekerjaan_ayah' => 'nullable|string|max:100',
                'penghasilan_per_bulan_ayah' => 'nullable|string|max:100',
                'nomor_telepon_ayah' => 'required|string|regex:/^[0-9]{10,16}$/|max:16',
                'email_ayah' => 'nullable|email|max:255',
                
                // Data Ibu
                'nama_lengkap_ibu' => 'required|string|max:255',
                'nik_ibu' => 'required|digits:16',
                'tempat_lahir_ibu' => 'required|string|max:100',
                'tanggal_lahir_ibu' => 'required|date',
                'pendidikan_ibu' => 'nullable|string|max:100',
                'pekerjaan_ibu' => 'nullable|in:' . implode(',', Spmb::PEKERJAAN_IBU_OPTIONS),
                'bidang_pekerjaan_ibu' => 'nullable|string|max:100',
                'penghasilan_per_bulan_ibu' => 'nullable|string|max:100',
                'nomor_telepon_ibu' => 'required|string|regex:/^[0-9]{10,16}$/|max:16',
                'email_ibu' => 'nullable|email|max:255',
                
                // Data Wali
                'punya_wali' => 'nullable|boolean',
                'nama_lengkap_wali' => 'nullable|string|max:255',
                'hubungan_dengan_anak' => 'nullable|in:' . implode(',', Spmb::HUBUNGAN_WALI_OPTIONS),
                'nik_wali' => 'nullable|digits:16',
                'tempat_lahir_wali' => 'nullable|string|max:100',
                'tanggal_lahir_wali' => 'nullable|date',
                'pendidikan_wali' => 'nullable|string|max:100',
                'pekerjaan_wali' => 'nullable|string|max:100',
                'bidang_pekerjaan_wali' => 'nullable|string|max:100',
                'penghasilan_per_bulan_wali' => 'nullable|string|max:100',
                'nomor_telepon_wali' => 'nullable|string|regex:/^[0-9]{10,16}$/|max:16',
                'email_wali' => 'nullable|email|max:255',
                
                // Informasi Tambahan
                'sumber_informasi_ppdb' => 'nullable|in:' . implode(',', Spmb::SUMBER_INFORMASI_OPTIONS),
                'punya_saudara_sekolah_tk' => 'nullable|in:' . implode(',', Spmb::PUNYA_SAUDARA_SEKOLAH_TK_OPTIONS),
                'jenis_daftar' => 'required|in:' . implode(',', Spmb::JENIS_DAFTAR_OPTIONS),
                
                // Foreign Key
                'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            ]);
            
            // Set boolean values
            $validated['alamat_kk_sama'] = $request->has('alamat_kk_sama');
            $validated['punya_wali'] = $request->has('punya_wali');
            $validated['punya_saudara_sekolah_tk'] = $request->punya_saudara_sekolah_tk ?? 'Tidak';
            
            DB::beginTransaction();
            
            // Update SPMB record
            $spmb->update($validated);
            
            // Catat riwayat update
            $spmb->riwayatStatus()->create([
                'status_sebelumnya' => $spmb->status_pendaftaran,
                'status_baru' => $spmb->status_pendaftaran,
                'keterangan' => 'Data pendaftaran diperbarui oleh admin',
                'diubah_oleh' => auth()->id(),
                'role_pengubah' => auth()->user()->role ?? 'admin'
            ]);
            
            // Handle dokumen uploads (jika ada file baru)
            $this->handleDokumenUploads($request, $spmb);
            
            DB::commit();
            
            return redirect()->route('admin.spmb.show', $spmb)
                ->with('success', 'Data pendaftaran SPMB berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SpmbController@update Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal memperbarui data pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spmb $spmb)
    {
        try {
            if ($spmb->siswa()->exists()) {
                return redirect()->route('admin.spmb.index')
                    ->with('error', 'Tidak dapat menghapus data yang sudah dikonversi menjadi siswa.');
            }
            
            DB::beginTransaction();
            
            $spmb->dokumen()->delete();
            $spmb->buktiTransfer()->delete();
            $spmb->riwayatStatus()->delete();
            
            foreach ($spmb->dokumen as $dokumen) {
                if (Storage::disk('public')->exists($dokumen->path_file)) {
                    Storage::disk('public')->delete($dokumen->path_file);
                }
            }
            
            $spmb->delete();
            
            DB::commit();
            
            return redirect()->route('admin.spmb.index')
                ->with('success', 'Data pendaftaran SPMB berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SpmbController@destroy Error: ' . $e->getMessage());
            
            return redirect()->route('admin.spmb.index')
                ->with('error', 'Gagal menghapus data pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Update status SPMB
     */
    public function updateStatus(Request $request, Spmb $spmb)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Verifikasi,Revisi Dokumen,Dokumen Verified,Lulus,Tidak Lulus',
            'catatan' => 'nullable|string',
            'catatan_admin' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();
            
            $oldStatus = $spmb->status_pendaftaran;
            $newStatus = $request->status;

            $spmb->setStatus($newStatus, auth()->id(), $request->catatan);

            if ($request->has('catatan_admin')) {
                $spmb->catatan_admin = $request->catatan_admin;
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = 'foto_' . $spmb->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('spmb/foto', $filename, 'public');
                $spmb->foto_calon_siswa = $path;
            }

            $spmb->save();

            if ($newStatus === 'Lulus' && $oldStatus !== 'Lulus' && !$spmb->siswa()->exists()) {
                try {
                    $siswa = $this->autoConvertToSiswa($spmb);
                    
                    DB::commit();
                    
                    $message = 'Status berhasil diperbarui dan data siswa berhasil dibuat.';
                    
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => true,
                            'message' => $message,
                            'spmb' => $spmb->fresh(['siswa']),
                            'siswa' => $siswa,
                            'redirect' => route('admin.siswa.show', $siswa)
                        ]);
                    }
                    
                    return redirect()->route('admin.siswa.show', $siswa)
                        ->with('success', $message);
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    
                    Log::error('Auto convert failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    $errorMessage = 'Gagal konversi ke siswa: ' . $e->getMessage();
                    
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => $errorMessage
                        ], 500);
                    }
                    
                    return back()->with('error', $errorMessage);
                }
            }

            DB::commit();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diperbarui.',
                    'spmb' => $spmb->fresh(['siswa'])
                ]);
            }
            
            return back()->with('success', 'Status berhasil diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('UpdateStatus Error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal update status: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    /**
     * Verifikasi dokumen
     */
    public function verifikasiDokumen(Request $request, Spmb $spmb)
    {
        $request->validate([
            'jenis' => 'required|in:akte,kk,ktp',
        ]);

        try {
            $spmb->verifikasiDokumen($request->jenis, auth()->id());
            
            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diverifikasi.',
                'progress' => $spmb->progress_verifikasi
            ]);
            
        } catch (\Exception $e) {
            Log::error('VerifikasiDokumen Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal verifikasi dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve Kepala Sekolah
     */
    public function approveKepsek(Spmb $spmb)
    {
        try {
            $spmb->approveKepsek(auth()->id());
            
            return response()->json([
                'success' => true,
                'message' => 'Persetujuan Kepala Sekolah berhasil.',
                'spmb' => $spmb->fresh()
            ]);
            
        } catch (\Exception $e) {
            Log::error('ApproveKepsek Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal approve: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assign kelas
     */
    public function assignKelas(Request $request, Spmb $spmb)
    {
        $request->validate([
            'kelas' => 'required|string|max:50',
            'guru_kelas' => 'required|string|max:255',
        ]);

        try {
            $spmb->assignKelas($request->kelas, $request->guru_kelas, auth()->id());
            
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditetapkan.',
                'spmb' => $spmb->fresh()
            ]);
            
        } catch (\Exception $e) {
            Log::error('AssignKelas Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal assign kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Konversi SPMB menjadi Siswa
     */
    public function konversiKeSiswa(Spmb $spmb)
    {
        try {
            DB::beginTransaction();
            
            if ($spmb->status_pendaftaran !== 'Lulus') {
                throw new \Exception('Hanya pendaftaran yang sudah diterima yang dapat dikonversi menjadi siswa.');
            }
            
            if ($spmb->siswa()->exists()) {
                throw new \Exception('Data ini sudah dikonversi menjadi siswa sebelumnya.');
            }
            
            $siswa = $this->autoConvertToSiswa($spmb);
            
            DB::commit();
            
            return redirect()->route('admin.siswa.show', $siswa)
                ->with('success', 'Data SPMB berhasil dikonversi menjadi data siswa.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('SpmbController@konversiKeSiswa Error: ' . $e->getMessage());
            
            return redirect()->route('admin.spmb.show', $spmb)
                ->with('error', 'Gagal mengkonversi ke siswa: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard SPMB
     */
    public function dashboard()
    {
        try {
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            
            $statistik = Spmb::getStatistik($tahunAjaranId);
            
            // Grafik pendaftaran per bulan
            $grafikBulanan = Spmb::select(
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();
            
            // Data status pendaftaran
            $statusPendaftaran = [
                'Lulus' => Spmb::where('status_pendaftaran', 'Lulus')
                    ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                    ->count(),
                'Menunggu Verifikasi' => Spmb::where('status_pendaftaran', 'Menunggu Verifikasi')
                    ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                    ->count(),
                'Tidak Lulus' => Spmb::where('status_pendaftaran', 'Tidak Lulus')
                    ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                    ->count(),
            ];
            
            // Pendaftar terbaru
            $pendaftarTerbaru = Spmb::with(['tahunAjaran'])
                ->latest()
                ->take(10)
                ->get();
            
            return view('admin.spmb.dashboard', compact(
                'statistik',
                'grafikBulanan',
                'statusPendaftaran',
                'pendaftarTerbaru',
                'tahunAjaranAktif'
            ));
            
        } catch (\Exception $e) {
            Log::error('SpmbController@dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat dashboard: ' . $e->getMessage());
        }
    }

    /**
     * Pengaturan PPDB
     */
    public function pengaturan(Request $request)
    {
        try {
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            
            $setting = SpmbSetting::where('tahun_ajaran', $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : date('Y') . '/' . (date('Y') + 1))
                ->first();
            
            if (!$setting) {
                $setting = SpmbSetting::create([
                    'tahun_ajaran' => $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : date('Y') . '/' . (date('Y') + 1),
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'gelombang' => 1,
                ]);
            }
            
            $totalPendaftaran = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count();
            $totalLulus = Spmb::where('status_pendaftaran', 'Lulus')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count();
            $kuota = 500;
            
            return view('admin.ppdb.pengaturan', compact(
                'setting',
                'tahunAjaranAktif',
                'totalPendaftaran',
                'totalLulus',
                'kuota'
            ));
            
        } catch (\Exception $e) {
            Log::error('SpmbController@pengaturan Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Update Pengaturan PPDB
     */
    public function updatePengaturan(Request $request)
    {
        try {
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
            $tahunAjaran = $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : date('Y') . '/' . (date('Y') + 1);
            
            $setting = SpmbSetting::where('tahun_ajaran', $tahunAjaran)->first();
            
            if (!$setting) {
                $setting = new SpmbSetting();
                $setting->tahun_ajaran = $tahunAjaran;
                $setting->tahun_ajaran_id = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            }
            
            $setting->pendaftaran_mulai = $request->pendaftaran_mulai;
            $setting->pendaftaran_selesai = $request->pendaftaran_selesai;
            $setting->pengumuman_mulai = $request->pengumuman_mulai;
            $setting->save();
            
            return back()->with('success', 'Pengaturan berhasil disimpan!');
            
        } catch (\Exception $e) {
            Log::error('SpmbController@updatePengaturan Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Pengumuman Kelulusan PPDB
     */
    public function pengumuman(Request $request)
    {
        try {
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            
            $tahunAjaran = $request->get('tahun_ajaran', $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : date('Y') . '/' . (date('Y') + 1));
            
            $setting = SpmbSetting::where('tahun_ajaran', $tahunAjaran)->first();
            $isPengumumanPublished = $setting && $setting->is_published;
            
            $query = Spmb::with(['tahunAjaran'])
                ->where('status_pendaftaran', 'Lulus');
            
            if ($tahunAjaranId) {
                $query->where('tahun_ajaran_id', $tahunAjaranId);
            }
            
            $search = $request->get('search', '');
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('no_pendaftaran', 'like', "%{$search}%")
                      ->orWhere('nama_lengkap_anak', 'like', "%{$search}%");
                });
            }
            
            $siswaLulus = $query->orderBy('nama_lengkap_anak', 'asc')->paginate(10);
            
            $totalLulus = Spmb::where('status_pendaftaran', 'Lulus')
                ->when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))
                ->count();
            
            $totalPendaftaran = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count();
            
            $persentase = $totalPendaftaran > 0 ? round(($totalLulus / $totalPendaftaran) * 100, 1) : 0;
            
            $tahunAjaranList = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
            
            $setting = SpmbSetting::where('tahun_ajaran', $tahunAjaran)->first();
            $isPengumumanPublished = $setting && $setting->is_published;
            
            return view('admin.ppdb.pengumuman', compact(
                'siswaLulus',
                'totalLulus',
                'totalPendaftaran',
                'persentase',
                'tahunAjaranList',
                'tahunAjaranAktif',
                'tahunAjaran',
                'search',
                'isPengumumanPublished'
            ));
            
        } catch (\Exception $e) {
            Log::error('SpmbController@pengumuman Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Publish Pengumuman
     */
    public function publishPengumuman(Request $request)
    {
        try {
            $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
            
            if (!$tahunAjaranAktif) {
                return back()->with('error', 'Tidak ada tahun ajaran aktif!');
            }
            
            $konversiSiswa = $request->has('konversi_siswa') && $request->konversi_siswa == 1;
            
            $semuaSiswa = Spmb::where('tahun_ajaran_id', $tahunAjaranId)->get();
            
            $jumlahDikonversi = 0;
            $jumlahDiarsipkan = 0;
            
            foreach ($semuaSiswa as $spmb) {
                $oldStatus = $spmb->status_pendaftaran;
                
                // Arsipkan ke tabel riwayat terlebih dahulu
                SpmbArsip::create([
                    'spmb_asli_id' => $spmb->id,
                    'no_pendaftaran' => $spmb->no_pendaftaran,
                    'tahun_ajaran_id' => $spmb->tahun_ajaran_id,
                    'nama_lengkap_anak' => $spmb->nama_lengkap_anak,
                    'nik_anak' => $spmb->nik_anak,
                    'jenis_kelamin' => $spmb->jenis_kelamin,
                    'tanggal_lahir_anak' => $spmb->tanggal_lahir_anak,
                    'status_pendaftaran' => $oldStatus,
                    'is_aktif' => false,
                    'data_lengkap' => $spmb->toArray(),
                ]);
                
                $jumlahDiarsipkan++;
                
                if ($oldStatus === 'Lulus') {
                    // Update status dengan riwayat
                    $spmb->setStatus('Lulus', auth()->id(), 'Pengumuman kelulusan dipublish');
                    
                    // Konversi ke siswa jika checkbox dicentang
                    if ($konversiSiswa && !$spmb->siswa) {
                        $existingSiswa = Siswa::where('nik', $spmb->nik_anak)->first();
                        if (!$existingSiswa) {
                            $tahunAjaran = $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : date('Y');
                            $jk = $spmb->jenis_kelamin === 'Perempuan' ? 'P' : 'L';
                            
                            $siswaBaru = Siswa::create([
                                'nama_lengkap' => $spmb->nama_lengkap_anak,
                                'nama_panggilan' => $spmb->nama_panggilan_anak,
                                'nik' => $spmb->nik_anak,
                                'tempat_lahir' => $spmb->tempat_lahir_anak,
                                'tanggal_lahir' => $spmb->tanggal_lahir_anak,
                                'jenis_kelamin' => $jk,
                                'agama' => $spmb->agama,
                                'alamat' => $spmb->nama_jalan_rumah,
                                'provinsi' => $spmb->provinsi_rumah,
                                'kota_kabupaten' => $spmb->kota_kabupaten_rumah,
                                'kecamatan' => $spmb->kecamatan_rumah,
                                'kelurahan' => $spmb->kelurahan_rumah,
                                'tahun_ajaran' => $tahunAjaran,
                                'tahun_ajaran_id' => $tahunAjaranId,
                                'status_siswa' => 'Aktif',
                                'spmb_id' => $spmb->id,
                            ]);
                            
                            $spmb->update(['siswa_id' => $siswaBaru->id]);
                            $jumlahDikonversi++;
                        }
                    }
                } else {
                    // Update status Tidak Lulus dengan riwayat
                    $spmb->setStatus('Tidak Lulus', auth()->id(), 'Pengumuman kelulusan dipublish - Tidak Lulus');
                }
                
                // Hapus data SPMB asli setelah diarsipkan
                $spmb->delete();
            }
            
            $setting = SpmbSetting::where('tahun_ajaran', $tahunAjaranAktif->tahun_ajaran)->first();
            if ($setting) {
                $setting->update([
                    'status_pengumuman' => 'published',
                    'published_at' => now(),
                    'published_by' => auth()->id(),
                ]);
            }
            
            $message = 'Pengumuman berhasil dipublish!';
            if ($konversiSiswa) {
                if ($jumlahDikonversi > 0) {
                    $message .= " {$jumlahDikonversi} siswa telah ditambahkan ke Data Siswa.";
                } else {
                    $message .= " Semua siswa lulus sudah ada di Data Siswa.";
                }
            }
            $message .= " {$jumlahDiarsipkan} data pendaftaran telah dicatat di Riwayat.";
            
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('SpmbController@publishPengumuman Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal publish pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Riwayat PPDB - List Tahun Ajaran
     */
    public function riwayat(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $range = $request->get('range', '');
            
            $query = TahunAjaran::query()->orderBy('tahun_ajaran', 'desc');
            
            if ($range) {
                $query->limit((int)$range);
            }
            
            $tahunAjaranList = $query->get();
            
            $riwayatData = [];
            $previousTotal = null;
            
            foreach ($tahunAjaranList as $ta) {
                $totalPendar = Spmb::where('tahun_ajaran_id', $ta->id)->count();
                $totalLulus = Spmb::where('tahun_ajaran_id', $ta->id)
                    ->where('status_pendaftaran', 'Lulus')
                    ->count();
                
                $persentaseKelulusan = $totalPendar > 0 ? round(($totalLulus / $totalPendar) * 100, 1) : 0;
                $persentaseKenaikan = $previousTotal && $previousTotal > 0 
                    ? round((($totalPendar - $previousTotal) / $previousTotal) * 100, 1) 
                    : 0;
                
                $riwayatData[] = (object) [
                    'tahun_ajaran' => $ta->tahun_ajaran,
                    'total_pendaftar' => $totalPendar,
                    'total_diterima' => $totalLulus,
                    'persentase_kelulusan' => $persentaseKelulusan,
                    'persentase_kenaikan' => $persentaseKenaikan,
                ];
                
                $previousTotal = $totalPendar;
            }
            
            $riwayat = collect($riwayatData);
            
            if ($search) {
                $riwayat = $riwayat->filter(function($item) use ($search) {
                    return str_contains(strtolower($item->tahun_ajaran), strtolower($search));
                });
            }
            
            $page = request()->get('page', 1);
            $perPage = 10;
            $riwayat = new LengthAwarePaginator(
                $riwayat->forPage($page, $perPage),
                $riwayat->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            
            return view('admin.ppdb.riwayat', compact('riwayat', 'search', 'range'));
            
        } catch (\Exception $e) {
            Log::error('SpmbController@riwayat Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat riwayat: ' . $e->getMessage());
        }
    }

    /**
     * Riwayat PPDB - Show Detail per Tahun Ajaran
     */
    public function riwayatShow(Request $request, $tahunAjaran)
    {
        try {
            $tahunAjaranData = TahunAjaran::where('tahun_ajaran', $tahunAjaran)->firstOrFail();
            
            $query = Spmb::with(['tahunAjaran'])
                ->where('tahun_ajaran_id', $tahunAjaranData->id);
            
            $status = $request->get('status', '');
            if ($status) {
                $query->where('status_pendaftaran', $status);
            }
            
            $search = $request->get('search', '');
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('no_pendaftaran', 'like', "%{$search}%")
                      ->orWhere('nama_lengkap_anak', 'like', "%{$search}%");
                });
            }
            
            $siswa = $query->orderBy('nama_lengkap_anak', 'asc')->paginate(10);
            
            $totalPendar = Spmb::where('tahun_ajaran_id', $tahunAjaranData->id)->count();
            $totalLulus = Spmb::where('tahun_ajaran_id', $tahunAjaranData->id)
                ->where('status_pendaftaran', 'Lulus')
                ->count();
            $totalDitolak = Spmb::where('tahun_ajaran_id', $tahunAjaranData->id)
                ->where('status_pendaftaran', 'Ditolak')
                ->count();
            $totalMenunggu = Spmb::where('tahun_ajaran_id', $tahunAjaranData->id)
                ->where('status_pendaftaran', 'Menunggu Verifikasi')
                ->count();

            return view('admin.ppdb.riwayat-show', [
                'siswa' => $siswa,
                'tahunAjaran' => $tahunAjaran,
                'tahunAjaranData' => $tahunAjaranData,
                'status' => $status,
                'search' => $search,
                'totalPendar' => $totalPendar,
                'totalLulus' => $totalLulus,
                'totalDitolak' => $totalDitolak,
                'totalMenunggu' => $totalMenunggu,
            ]);
            
        } catch (\Exception $e) {
            Log::error('SpmbController@riwayatShow Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail riwayat: ' . $e->getMessage());
        }
    }

    // ==================== PRIVATE METHODS ====================

    /**
     * ✅ FUNGSI BARU: Normalisasi input tinggal_bersama
     * Memastikan semua input konsisten sebelum validasi
     */
    private function normalizeTinggalBersamaInput(Request $request)
    {
        if ($request->has('tinggal_bersama')) {
            $input = $request->tinggal_bersama;
            
            // Map berbagai kemungkinan input ke nilai standar
            $map = [
                // Lowercase ke proper case
                'ayah' => 'Ayah',
                'ibu' => 'Ibu',
                'ayah dan ibu' => 'Ayah dan Ibu',
                'keluarga ayah' => 'Keluarga Ayah',
                'keluarga ibu' => 'Keluarga Ibu',
                'lainnya' => 'Lainnya',
                
                // Dengan spasi berlebih
                'Ayah  dan Ibu' => 'Ayah dan Ibu',
                'Keluarga  Ayah' => 'Keluarga Ayah',
                'Keluarga  Ibu' => 'Keluarga Ibu',
                
                // Variasi lain
                'Ayah & Ibu' => 'Ayah dan Ibu',
                'Ayah&Ibu' => 'Ayah dan Ibu',
            ];
            
            $normalized = $map[$input] ?? $input;
            
            // Pastikan hanya nilai yang valid yang diteruskan
            if (in_array($normalized, Spmb::TINGGAL_BERSAMA_OPTIONS)) {
                $request->merge(['tinggal_bersama' => $normalized]);
            } else {
                // Default ke Lainnya jika tidak dikenal
                $request->merge(['tinggal_bersama' => 'Lainnya']);
            }
        }
    }

    /**
     * Generate nomor pendaftaran SPMB
     */
    private function generateNomorPendaftaran()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $tanggal = date('d');
        
        $count = Spmb::whereDate('created_at', today())->count() + 1;
        
        return 'PPDB-' . $tahun . $bulan . $tanggal . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Auto convert to siswa
     */
    private function autoConvertToSiswa($spmb)
    {
        try {
            // CEK DUPLIKAT NIK
            $existingSiswa = Siswa::where('nik', $spmb->nik_anak)->first();
                
            if ($existingSiswa) {
                throw new \Exception("Siswa dengan NIK {$spmb->nik_anak} sudah terdaftar sebagai {$existingSiswa->nama_lengkap}");
            }
            
            if (!$spmb->tanggal_lahir_anak) {
                throw new \Exception('Tanggal lahir tidak valid');
            }
            
            $usia = Carbon::parse($spmb->tanggal_lahir_anak)->age;
            $kelompok = ($usia >= 3 && $usia <= 4) ? 'A' : 'B';
            
            $tahunAjaranId = $spmb->tahun_ajaran_id;
            $tahunAjaranString = $spmb->tahunAjaran->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1);
            
            $alamatLengkap = $this->buildAlamatLengkap($spmb);

            $siswaData = [
                'spmb_id' => $spmb->id,
                
                'nik' => $spmb->nik_anak,
                'nama_lengkap' => $spmb->nama_lengkap_anak,
                'nama_panggilan' => $spmb->nama_panggilan_anak,
                'tempat_lahir' => $spmb->tempat_lahir_anak,
                'tanggal_lahir' => $spmb->tanggal_lahir_anak,
                'jenis_kelamin' => $spmb->jenis_kelamin == 'Laki-laki' ? 'L' : 'P',
                'agama' => $spmb->agama,
                
                'alamat' => $alamatLengkap,
                'provinsi' => $spmb->provinsi_rumah,
                'kota_kabupaten' => $spmb->kota_kabupaten_rumah,
                'kecamatan' => $spmb->kecamatan_rumah,
                'kelurahan' => $spmb->kelurahan_rumah,
                'nama_jalan' => $spmb->nama_jalan_rumah,
                
                'berat_badan' => $spmb->berat_badan,
                'tinggi_badan' => $spmb->tinggi_badan,
                'golongan_darah' => $spmb->golongan_darah,
                'penyakit_pernah_diderita' => $spmb->penyakit_pernah_diderita,
                'imunisasi' => $spmb->imunisasi_pernah_diterima,
                
                'nama_ayah' => $spmb->nama_lengkap_ayah,
                'nik_ayah' => $spmb->nik_ayah,
                'tempat_lahir_ayah' => $spmb->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $spmb->tanggal_lahir_ayah,
                'pendidikan_ayah' => $spmb->pendidikan_ayah,
                'pekerjaan_ayah' => $spmb->pekerjaan_ayah,
                'bidang_pekerjaan_ayah' => $spmb->bidang_pekerjaan_ayah,
                'penghasilan_ayah' => $spmb->penghasilan_per_bulan_ayah,
                
                'nama_ibu' => $spmb->nama_lengkap_ibu,
                'nik_ibu' => $spmb->nik_ibu,
                'tempat_lahir_ibu' => $spmb->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $spmb->tanggal_lahir_ibu,
                'pendidikan_ibu' => $spmb->pendidikan_ibu,
                'pekerjaan_ibu' => $spmb->pekerjaan_ibu,
                'bidang_pekerjaan_ibu' => $spmb->bidang_pekerjaan_ibu,
                'penghasilan_ibu' => $spmb->penghasilan_per_bulan_ibu,
                
                'punya_wali' => $spmb->punya_wali,
                'nama_wali' => $spmb->nama_lengkap_wali,
                'hubungan_wali' => $spmb->hubungan_dengan_anak,
                'nik_wali' => $spmb->nik_wali,
                'pekerjaan_wali' => $spmb->pekerjaan_wali,
                'nomor_telepon_wali' => $spmb->nomor_telepon_wali,
                
                'no_hp_ayah' => $spmb->nomor_telepon_ayah,
                'email_ayah' => $spmb->email_ayah,
                'no_hp_ibu' => $spmb->nomor_telepon_ibu,
                'email_ibu' => $spmb->email_ibu,
                'no_hp_ortu' => $spmb->nomor_telepon_ayah ?? $spmb->nomor_telepon_ibu,
                'email_ortu' => $spmb->email_ayah ?? $spmb->email_ibu,
                
                'kelompok' => $kelompok,
                'tahun_ajaran_id' => $tahunAjaranId,
                'tahun_ajaran' => $tahunAjaranString,
                'status_siswa' => 'aktif',
                'tanggal_masuk' => now(),
                'jalur_masuk' => $this->mapJalurPendaftaran($spmb->jenis_daftar),
            ];

            $siswa = Siswa::create($siswaData);
            
            $spmb->is_aktif = true;
            $spmb->nomor_induk_siswa = $this->generateNIS($tahunAjaranId);
            $spmb->save();
            
            return $siswa;
            
        } catch (\Exception $e) {
            Log::error('Auto convert failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate NIS (Nomor Induk Siswa)
     */
    private function generateNIS($tahunAjaranId)
    {
        $tahun = date('Y');
        $tahunAjaran = TahunAjaran::find($tahunAjaranId);
        $tahunString = $tahunAjaran ? substr($tahunAjaran->tahun_ajaran, 0, 4) : $tahun;
        
        $lastSiswa = Siswa::where('tahun_ajaran_id', $tahunAjaranId)
                         ->whereNotNull('nis')
                         ->orderByRaw('CAST(SUBSTRING_INDEX(nis, "-", -1) AS UNSIGNED) DESC')
                         ->first();
        
        if ($lastSiswa && $lastSiswa->nis) {
            $lastNumber = intval(substr($lastSiswa->nis, strrpos($lastSiswa->nis, '-') + 1));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return 'NIS-' . $tahunString . '-' . $newNumber;
    }

    /**
     * Helper function untuk membuat alamat lengkap
     */
    private function buildAlamatLengkap($spmb)
    {
        $alamatParts = [];
        
        if (!empty($spmb->nama_jalan_rumah)) {
            $alamatParts[] = $spmb->nama_jalan_rumah;
        }
        
        if (!empty($spmb->kelurahan_rumah)) {
            $alamatParts[] = 'Kel. ' . $spmb->kelurahan_rumah;
        }
        
        if (!empty($spmb->kecamatan_rumah)) {
            $alamatParts[] = 'Kec. ' . $spmb->kecamatan_rumah;
        }
        
        if (!empty($spmb->kota_kabupaten_rumah)) {
            $alamatParts[] = $spmb->kota_kabupaten_rumah;
        }
        
        if (!empty($spmb->provinsi_rumah)) {
            $alamatParts[] = $spmb->provinsi_rumah;
        }
        
        $alamat = implode(', ', $alamatParts);
        
        if (empty($alamat)) {
            $alamat = 'Alamat tidak tersedia';
        }
        
        return $alamat;
    }

    /**
     * Map jalur pendaftaran
     */
    private function mapJalurPendaftaran($jenisDaftar)
    {
        $map = [
            'Siswa Baru' => 'reguler',
            'Pindahan' => 'mutasi'
        ];
        
        return $map[$jenisDaftar] ?? 'reguler';
    }

    /**
     * Handle dokumen uploads
     */
    private function handleDokumenUploads(Request $request, Spmb $spmb)
    {
        $dokumenTypes = [
            'akte' => 'akte_kelahiran',
            'kk' => 'kartu_keluarga',
            'ktp' => 'ktp_orang_tua'
        ];
        
        foreach ($dokumenTypes as $jenis => $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $originalName = $file->getClientOriginalName();
                $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
                
                $path = $file->storeAs('spmb/dokumen/' . $jenis, $safeName, 'public');
                
                SpmbDokumen::create([
                    'spmb_id' => $spmb->id,
                    'jenis_dokumen' => $jenis,
                    'nama_file' => $originalName,
                    'path_file' => $path,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_file' => round($file->getSize() / 1024, 2),
                ]);
            }
        }
    }

    /**
     * Preview pembagian kelas
     */
    public function classDivisionPreview(Request $request)
    {
        try {
            $tahunAjaranId = $request->tahun_ajaran_id;
            
            if (!$tahunAjaranId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran tidak dipilih'
                ]);
            }
            
            $students = Spmb::where('status_pendaftaran', 'Lulus')
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->whereNull('kelas')
                ->orderBy('tanggal_lahir_anak', 'desc')
                ->get(['id', 'nama_lengkap_anak as nama', 'tanggal_lahir_anak']);
            
            $formattedStudents = $students->map(function($siswa) {
                $usia = Carbon::parse($siswa->tanggal_lahir_anak)->age;
                return [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'usia' => $usia . ' tahun',
                    'tanggal_lahir' => Carbon::parse($siswa->tanggal_lahir_anak)->format('d/m/Y')
                ];
            });
            
            return response()->json([
                'success' => true,
                'students' => $formattedStudents,
                'total' => $students->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Class division preview error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eksekusi pembagian kelas
     */
    public function executeClassDivision(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $tahunAjaranId = $request->tahun_ajaran_id;
            $kelompokAIds = $request->kelompok_a;
            $kelompokBIds = $request->kelompok_b;
            
            if (!$tahunAjaranId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran tidak dipilih'
                ]);
            }
            
            Spmb::whereIn('id', $kelompokAIds)
                ->update(['kelas' => 'Kelompok A']);
            
            Spmb::whereIn('id', $kelompokBIds)
                ->update(['kelas' => 'Kelompok B']);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pembagian kelas berhasil',
                'result' => [
                    'kelompok_a' => count($kelompokAIds),
                    'kelompok_b' => count($kelompokBIds),
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Execute class division error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk luluskan pendaftar
     */
    public function bulkLulus(Request $request)
    {
        $ids = explode(',', $request->selected_ids);
        
        Spmb::whereIn('id', $ids)->update([
            'status_pendaftaran' => 'Lulus'
        ]);

        return redirect()->back()->with('success', count($ids) . ' p berhasil diluluskan.');
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->selected_ids);
        
        Spmb::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}