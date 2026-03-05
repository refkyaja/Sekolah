<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Akademik - {{ $currentMonth->translatedFormat('F Y') }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4c99e6;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #0f172a;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
        }
        .info {
            margin-bottom: 25px;
            font-size: 12px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 2px 0;
        }
        .calendar-title {
            background-color: #f8fafc;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .calendar-title h2 {
            margin: 0;
            color: #4c99e6;
            font-size: 18px;
        }
        table.events {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.events th {
            background-color: #4c99e6;
            color: white;
            text-align: left;
            padding: 12px;
            font-size: 12px;
            text-transform: uppercase;
        }
        table.events td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            vertical-align: top;
        }
        .date-badge {
            font-weight: bold;
            color: #0f172a;
            white-space: nowrap;
        }
        .category-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
        }
        .legend {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f5f9;
            border-radius: 8px;
        }
        .legend h4 {
            margin: 0 0 10px;
            font-size: 12px;
            color: #475569;
        }
        .legend-item {
            display: inline-block;
            margin-right: 20px;
            font-size: 10px;
        }
        .legend-color {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 2px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TK Harapan Bangsa 2</h1>
        <p>Kalender Akademik Periode {{ $currentMonth->translatedFormat('F Y') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Nama Siswa</strong></td>
                <td width="35%">: {{ $siswa->nama_lengkap }}</td>
                <td width="15%"><strong>Kelas</strong></td>
                <td width="35%">: {{ $siswa->kelas }} - {{ $siswa->kelompok }}</td>
            </tr>
            <tr>
                <td><strong>Dicetak pada</strong></td>
                <td>: {{ now()->translatedFormat('d F Y H:i') }}</td>
                <td><strong>Status</strong></td>
                <td>: Dokumen Resmi</td>
            </tr>
        </table>
    </div>

    <div class="calendar-title">
        <h2>Daftar Agenda Kegiatan</h2>
    </div>

    <table class="events">
        <thead>
            <tr>
                <th width="20%">Tanggal</th>
                <th width="20%">Kategori</th>
                <th width="60%">Kegiatan & Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                @php
                    $classes = $event->tailwind_classes;
                    $bgColor = match($event->kategori) {
                        'Libur Nasional' => '#fee2e2',
                        'Ujian' => '#dbeafe',
                        'Kegiatan Sekolah' => '#e0f2fe',
                        'Rapat Guru' => '#ffedd5',
                        default => '#f1f5f9'
                    };
                    $textColor = match($event->kategori) {
                        'Libur Nasional' => '#991b1b',
                        'Ujian' => '#1e40af',
                        'Kegiatan Sekolah' => '#075985',
                        'Rapat Guru' => '#9a3412',
                        default => '#475569'
                    };
                @endphp
                <tr>
                    <td>
                        <div class="date-badge">
                            {{ $event->tanggal_mulai->translatedFormat('d M Y') }}
                            @if($event->tanggal_selesai)
                                <br><small style="color: #64748b; font-weight: normal;">s/d {{ $event->tanggal_selesai->translatedFormat('d M Y') }}</small>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="category-badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            {{ $event->kategori }}
                        </div>
                    </td>
                    <td>
                        <strong>{{ $event->judul }}</strong>
                        @if($event->deskripsi)
                            <p style="margin: 5px 0 0; color: #64748b; font-size: 11px;">{{ $event->deskripsi }}</p>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 30px; color: #94a3b8;">
                        Tidak ada agenda kegiatan untuk bulan ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="legend">
        <h4>Keterangan Warna:</h4>
        @foreach($daftarKategori as $key => $kat)
            @php
                $color = match($key) {
                    'Libur Nasional' => '#ef4444',
                    'Ujian' => '#4c99e6',
                    'Kegiatan Sekolah' => '#3b82f6',
                    'Rapat Guru' => '#f97316',
                    default => '#94a3b8'
                };
            @endphp
            <div class="legend-item">
                <span class="legend-color" style="background-color: {{ $color }};"></span>
                {{ str_replace(['🔴 ', '🟣 ', '🔵 ', '🟠 ', '⚪ '], '', $kat['label']) }}
            </div>
        @endforeach
    </div>

    <div class="footer">
        Dokumen ini diterbitkan secara otomatis oleh Sistem Informasi Akademik TK Harapan Bangsa 2.
    </div>
</body>
</html>
