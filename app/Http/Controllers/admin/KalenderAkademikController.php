<?php
// app/Http/Controllers/Admin/KalenderAkademikController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KalenderAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class KalenderAkademikController extends Controller
{
    /**
     * Display the calendar for the given month/year.
     */
    public function index(Request $request)
    {
        $year  = (int) $request->get('year',  now()->year);
        $month = (int) $request->get('month', now()->month);

        // Clamp month to 1-12
        if ($month < 1)  { $month = 12; $year--; }
        if ($month > 12) { $month = 1;  $year++; }

        $currentMonth = Carbon::create($year, $month, 1);
        $prevMonth    = $currentMonth->copy()->subMonth();
        $nextMonth    = $currentMonth->copy()->addMonth();

        // All events that touch this month
        $events = KalenderAkademik::inMonth($year, $month)
            ->where('is_aktif', true)
            ->orderBy('tanggal_mulai')
            ->get();

        // Group events by date (day number within the month)
        $eventsByDay = [];
        foreach ($events as $event) {
            $start = $event->tanggal_mulai->copy();
            $end   = $event->tanggal_selesai ?? $event->tanggal_mulai;

            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                if ($d->year == $year && $d->month == $month) {
                    $eventsByDay[$d->day][] = $event;
                }
            }
        }

        // Calendar grid: first day of month weekday offset + number of days
        $firstWeekday = $currentMonth->copy()->startOfMonth()->dayOfWeek; // 0=Sun
        $daysInMonth  = $currentMonth->daysInMonth;

        // Previous month days to fill the grid
        $prevDays = $firstWeekday; // how many days from previous month to show

        $daftarKategori = KalenderAkademik::daftarKategori();

        return view('admin.kalender-akademik.index', compact(
            'currentMonth', 'prevMonth', 'nextMonth',
            'year', 'month',
            'eventsByDay', 'firstWeekday', 'daysInMonth', 'prevDays',
            'daftarKategori'
        ));
    }

    /**
     * Show form to create a new event.
     */
    public function create()
    {
        $daftarKategori = KalenderAkademik::daftarKategori();
        return view('admin.kalender-akademik.create', compact('daftarKategori'));
    }

    /**
     * Store a new event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kategori'        => 'required|in:Libur Nasional,Ujian,Kegiatan Sekolah,Rapat Guru,Lainnya',
        ]);

        try {
            KalenderAkademik::create([
                'judul'           => $request->judul,
                'deskripsi'       => $request->deskripsi,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai ?: null,
                'kategori'        => $request->kategori,
                'is_aktif'        => true,
            ]);

            $year  = Carbon::parse($request->tanggal_mulai)->year;
            $month = Carbon::parse($request->tanggal_mulai)->month;

            return redirect()->route('admin.kalender-akademik.index', compact('year', 'month'))
                ->with('success', 'Agenda berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating kalender: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan agenda.');
        }
    }

    /**
     * Show form to edit an event.
     */
    public function edit(KalenderAkademik $kalenderAkademik)
    {
        $daftarKategori = KalenderAkademik::daftarKategori();
        return view('admin.kalender-akademik.edit', compact('kalenderAkademik', 'daftarKategori'));
    }

    /**
     * Update an event.
     */
    public function update(Request $request, KalenderAkademik $kalenderAkademik)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kategori'        => 'required|in:Libur Nasional,Ujian,Kegiatan Sekolah,Rapat Guru,Lainnya',
        ]);

        try {
            $kalenderAkademik->update([
                'judul'           => $request->judul,
                'deskripsi'       => $request->deskripsi,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai ?: null,
                'kategori'        => $request->kategori,
            ]);

            $year  = Carbon::parse($request->tanggal_mulai)->year;
            $month = Carbon::parse($request->tanggal_mulai)->month;

            return redirect()->route('admin.kalender-akademik.index', compact('year', 'month'))
                ->with('success', 'Agenda berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating kalender: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui agenda.');
        }
    }

    /**
     * Delete an event.
     */
    public function destroy(KalenderAkademik $kalenderAkademik)
    {
        try {
            $year  = $kalenderAkademik->tanggal_mulai->year;
            $month = $kalenderAkademik->tanggal_mulai->month;

            $kalenderAkademik->delete();

            return redirect()->route('admin.kalender-akademik.index', compact('year', 'month'))
                ->with('success', 'Agenda berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting kalender: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus agenda.');
        }
    }
}
