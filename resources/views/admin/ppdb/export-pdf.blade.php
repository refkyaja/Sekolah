<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export Data PPDB</title>
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
            page-break-inside: auto;
        }
        tr { page-break-inside: avoid; page-break-after: auto; }
        th, td { 
            border: 1px solid #000; 
            padding: 4px 6px; 
            text-align: left; 
            font-size: 9px;
            word-wrap: break-word;
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
        <h1>LAPORAN DATA PPDB</h1>
        @if($tahunAjaran)
        <p>Tahun Ajaran: {{ $tahunAjaran->tahun_ajaran }}</p>
        @else
        <p>Semua Tahun Ajaran</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;">No. Pendaftaran</th>
                <th style="width: 120px;">Nama Lengkap</th>
                <th style="width: 100px;">NIK</th>
                <th style="width: 60px;">NISN</th>
                <th style="width: 50px;">JK</th>
                <th style="width: 80px;">Tempat Lahir</th>
                <th style="width: 60px;">Tgl Lahir</th>
                <th style="width: 100px;">Nama Ayah</th>
                <th style="width: 100px;">Nama Ibu</th>
                <th style="width: 70px;">No. Telp</th>
                <th style="width: 60px;">Status</th>
                <th style="width: 60px;">Th. Ajaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->no_pendaftaran }}</td>
                <td>{{ $item->nama_lengkap_anak }}</td>
                <td>{{ $item->nik_anak }}</td>
                <td>{{ $item->nisn ?? '-' }}</td>
                <td>{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $item->tempat_lahir_anak }}</td>
                <td>{{ $item->tanggal_lahir_anak ? $item->tanggal_lahir_anak->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->nama_lengkap_ayah ?? '-' }}</td>
                <td>{{ $item->nama_lengkap_ibu ?? '-' }}</td>
                <td>{{ $item->nomor_telepon_ayah ?? $item->nomor_telepon_ibu ?? '-' }}</td>
                <td>{{ $item->status_pendaftaran }}</td>
                <td>{{ $item->tahunAjaran?->tahun_ajaran ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }} WIB</p>
    </div>
</body>
</html>
