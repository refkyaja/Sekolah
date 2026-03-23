<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first() ?? TahunAjaran::first();
        $selectedTahunAjaranId = $request->get('tahun_ajaran_id', $tahunAjaranAktif->id ?? null);
        $selectedSemester = $request->get('semester', $tahunAjaranAktif->semester ?? 'Ganjil');
        $selectedKelompok = $request->get('kelompok', 'A');

        $query = JadwalPelajaran::query()
            ->where('tahun_ajaran_id', $selectedTahunAjaranId)
            ->where('semester', $selectedSemester)
            ->where('kelompok', $selectedKelompok);

        $jadwal = $query->orderBy('jam_mulai')->get()->groupBy('hari');
        
        $daftarTahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return view('admin.jadwal.index', compact(
            'jadwal', 
            'daftarTahunAjaran', 
            'selectedTahunAjaranId', 
            'selectedSemester', 
            'selectedKelompok',
            'hariList'
        ));
    }

    public function create()
    {
        $daftarTahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        return view('admin.jadwal.create', compact('daftarTahunAjaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester' => 'required|in:Ganjil,Genap',
            'kelompok' => 'required|in:A,B',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mata_pelajaran' => 'required|string|max:255',
            'kategori' => 'required|in:akademik,art,physical,break,special',
            'lokasi' => 'nullable|string|max:255',
            'guru' => 'nullable|string|max:255',
        ]);

        JadwalPelajaran::create($validated);

        return redirect()->route('admin.jadwal.index', [
            'kelompok' => $request->kelompok,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'semester' => $request->semester
        ])->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $daftarTahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        return view('admin.jadwal.edit', compact('jadwalPelajaran', 'daftarTahunAjaran'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'semester' => 'required|in:Ganjil,Genap',
            'kelompok' => 'required|in:A,B',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mata_pelajaran' => 'required|string|max:255',
            'kategori' => 'required|in:akademik,art,physical,break,special',
            'lokasi' => 'nullable|string|max:255',
            'guru' => 'nullable|string|max:255',
        ]);

        $jadwalPelajaran->update($validated);

        return redirect()->route('admin.jadwal.index', [
            'kelompok' => $request->kelompok,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'semester' => $request->semester
        ])->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $kelompok = $jadwalPelajaran->kelompok;
        $ta = $jadwalPelajaran->tahun_ajaran_id;
        $sem = $jadwalPelajaran->semester;

        $jadwalPelajaran->delete();

        return redirect()->route('admin.jadwal.index', [
            'kelompok' => $kelompok,
            'tahun_ajaran_id' => $ta,
            'semester' => $sem
        ])->with('success', 'Jadwal berhasil dihapus');
    }
}
