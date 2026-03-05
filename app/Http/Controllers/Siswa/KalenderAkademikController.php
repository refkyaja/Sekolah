<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KalenderAkademik;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class KalenderAkademikController extends Controller
{
    /**
     * Display the academic calendar.
     */
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $year = (int) $request->get('year', Carbon::now()->year);
        $month = (int) $request->get('month', Carbon::now()->month);

        $currentMonth = Carbon::create($year, $month, 1);
        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        $events = KalenderAkademik::inMonth($year, $month)
            ->where('is_aktif', true)
            ->orderBy('tanggal_mulai')
            ->get();

        // Group events by day for efficiency
        $eventsByDay = [];
        foreach ($events as $event) {
            $start = $event->tanggal_mulai->copy();
            $end = $event->tanggal_selesai ?? $event->tanggal_mulai;

            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                if ($d->year == $year && $d->month == $month) {
                    $eventsByDay[$d->day][] = $event;
                }
            }
        }

        // Calendar grid logic
        $firstWeekday = $currentMonth->copy()->startOfMonth()->dayOfWeek; // 0=Sun
        $daysInMonth = $currentMonth->daysInMonth;
        
        $startOfCalendar = $currentMonth->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $days = [];
        $date = $startOfCalendar->copy();
        while ($date <= $endOfCalendar) {
            $days[] = [
                'date' => $date->copy(),
                'isCurrentMonth' => $date->month == $month,
                'isToday' => $date->isToday(),
                'events' => $date->month == $month ? ($eventsByDay[$date->day] ?? []) : []
            ];
            $date->addDay();
        }

        $daftarKategori = KalenderAkademik::daftarKategori();

        return view('siswa.kalender.index', compact('days', 'currentMonth', 'year', 'month', 'prevMonth', 'nextMonth', 'daftarKategori'));
    }

    /**
     * Download the academic calendar as PDF.
     */
    public function downloadPdf(Request $request)
    {
        Carbon::setLocale('id');
        $year = (int) $request->get('year', Carbon::now()->year);
        $month = (int) $request->get('month', Carbon::now()->month);

        $currentMonth = Carbon::create($year, $month, 1);

        $events = KalenderAkademik::inMonth($year, $month)
            ->where('is_aktif', true)
            ->orderBy('tanggal_mulai')
            ->get();

        $daftarKategori = KalenderAkademik::daftarKategori();
        $siswa = auth('siswa')->user();

        $pdf = Pdf::loadView('siswa.kalender.pdf', compact(
            'events', 
            'currentMonth', 
            'year', 
            'month', 
            'daftarKategori',
            'siswa'
        ));

        $filename = 'Kalender-Akademik-' . $currentMonth->translatedFormat('F-Y') . '.pdf';
        
        return $pdf->download($filename);
    }
}
