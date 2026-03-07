<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - Kelompok {{ $studentKelompok }}</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            line-height: 1.2;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4c99e6;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0f172a;
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0;
            color: #64748b;
            font-size: 12px;
        }
        .info {
            margin-bottom: 15px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 2px 0;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .schedule-table th {
            background-color: #f8fafc;
            color: #475569;
            text-align: center;
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .schedule-table td {
            padding: 8px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
            height: 60px;
        }
        .time-col {
            width: 80px;
            text-align: center;
            background-color: #f8fafc;
            font-weight: bold;
        }
        .day-col {
            width: 18%;
        }
        .lesson-card {
            padding: 6px;
            border-radius: 4px;
            height: 100%;
        }
        .lesson-title {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 9px;
        }
        .lesson-location {
            font-size: 8px;
            color: #64748b;
        }
        .break-row {
            background-color: #f1f5f9;
            text-align: center;
            font-style: italic;
            color: #64748b;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8px;
            color: #94a3b8;
        }
        
        /* Categories */
        .academic { background-color: #dbeafe; border-left: 3px solid #3b82f6; color: #1e40af; }
        .art { background-color: #fef3c7; border-left: 3px solid #f59e0b; color: #92400e; }
        .physical { background-color: #d1fae5; border-left: 3px solid #10b981; color: #065f46; }
        .special { background-color: #fae8ff; border-left: 3px solid #d946ef; color: #86198f; }
        .default { background-color: #f1f5f9; border-left: 3px solid #94a3b8; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TK Harapan Bangsa 1</h1>
        <p>Jadwal Pelajaran Kelompok {{ $studentKelompok }} - {{ $ta->tahun_ajaran }} ({{ $ta->semester }})</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Nama Siswa</strong></td>
                <td width="35%">: {{ $siswa->nama_lengkap }}</td>
                <td width="15%"><strong>Kelas/Kelp</strong></td>
                <td width="35%">: {{ $siswa->kelas }} - {{ $studentKelompok }}</td>
            </tr>
            <tr>
                <td><strong>Dicetak pada</strong></td>
                <td>: {{ now()->translatedFormat('d F Y H:i') }}</td>
                <td><strong>Lokasi Utama</strong></td>
                <td>: Gedung Utama, TK Harapan Bangsa 1</td>
            </tr>
        </table>
    </div>

    @php
        $jadwal = ($studentKelompok == 'A') ? $jadwalA : $jadwalB;
    @endphp

    <table class="schedule-table">
        <thead>
            <tr>
                <th class="time-col">Waktu</th>
                @foreach($hariList as $hari)
                    <th>{{ $hari }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($slots as $slot)
                @php
                    $jamMulai = \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i');
                    $jamSelesai = \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i');
                    
                    $isBreakRow = false;
                    foreach($hariList as $hari) {
                        $item = $jadwal->get($hari)?->firstWhere('jam_mulai', $slot->jam_mulai);
                        if ($item && $item->kategori === 'break') {
                            $isBreakRow = true;
                            break;
                        }
                    }
                @endphp

                @if($isBreakRow)
                    <tr class="break-row">
                        <td class="time-col">
                            {{ $jamMulai }} - {{ $jamSelesai }}
                        </td>
                        <td colspan="5" style="vertical-align: middle;">
                            ISTIRAHAT & MAKAN RINGAN
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="time-col">
                            {{ $jamMulai }} - {{ $jamSelesai }}
                        </td>
                        @foreach($hariList as $hari)
                            <td>
                                @php
                                    $item = $jadwal->get($hari)?->firstWhere('jam_mulai', $slot->jam_mulai);
                                @endphp
                                @if($item)
                                    @php
                                        $catClass = match($item->kategori) {
                                            'akademik' => 'academic',
                                            'art' => 'art',
                                            'physical' => 'physical',
                                            'special' => 'special',
                                            default => 'default'
                                        };
                                    @endphp
                                    <div class="lesson-card {{ $catClass }}">
                                        <div class="lesson-title">{{ $item->mata_pelajaran }}</div>
                                        <div class="lesson-location">{{ $item->lokasi }}</div>
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
            
            <tr class="break-row">
                <td class="time-col">11:30 - 12:00</td>
                <td colspan="5" style="vertical-align: middle;">
                    PERSIAPAN PULANG & PENJEMPUTAN
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini diterbitkan secara otomatis oleh Sistem Informasi Akademik TK Harapan Bangsa 1.
    </div>
</body>
</html>
