<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi Guru</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10px; 
            margin: 10px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .header h1 { 
            font-size: 16px; 
            margin: 0 0 5px 0; 
            color: #6B46C1;
        }
        .header p { 
            font-size: 11px; 
            margin: 0; 
            color: #666;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 4px 6px; 
            text-align: center; 
            font-size: 9px;
        }
        th { 
            background-color: #6B46C1; 
            color: white; 
            font-weight: bold;
        }
        .footer { 
            margin-top: 15px; 
            text-align: right; 
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP ABSENSI GURU</h1>
        <p>Bulan: {{ $bulan }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 120px;">Nama Guru</th>
                <th style="width: 60px;">NIP</th>
                <th style="width: 50px;">Hadir</th>
                <th style="width: 50px;">Sakit</th>
                <th style="width: 50px;">Izin</th>
                <th style="width: 50px;">Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $item->nama }}</td>
                <td>{{ $item->nip ?? '-' }}</td>
                <td style="color: green;">{{ (int) $item->hadir }}</td>
                <td style="color: orange;">{{ (int) $item->sakit }}</td>
                <td style="color: blue;">{{ (int) $item->izin }}</td>
                <td style="color: red;">{{ (int) $item->alpa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }} WIB</p>
    </div>
</body>
</html>
