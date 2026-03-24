<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export Data PPDB</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 8px; 
            margin: 5px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 10px; 
        }
        .header h1 { 
            font-size: 14px; 
            margin: 0 0 3px 0; 
            color: #6B46C1;
        }
        .header p { 
            font-size: 9px; 
            margin: 0; 
            color: #666;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 5px;
            table-layout: fixed;
        }
        th, td { 
            border: 0.5px solid #ccc; 
            padding: 2px 3px; 
            text-align: left; 
            font-size: 7px;
            word-wrap: break-word;
            overflow: hidden;
        }
        th { 
            background-color: #6B46C1; 
            color: white; 
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer { 
            margin-top: 10px; 
            text-align: right; 
            font-size: 7px;
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
                <th style="width: 15px;">No</th>
                <th style="width: 55px;">NIK Anak</th>
                <th style="width: 70px;">Nama Lengkap</th>
                <th style="width: 80px;">Tempat, Tanggal Lahir</th>
                <th style="width: 45px;">Umur</th>
                <th style="width: 40px;">Jenis Kelamin</th>
                <th style="width: 35px;">Agama</th>
                <th style="width: 60px;">Nama Ayah</th>
                <th style="width: 55px;">NIK Ayah</th>
                <th style="width: 55px;">Pekerjaan Ayah</th>
                <th style="width: 50px;">No HP Ayah</th>
                <th style="width: 60px;">Nama Ibu</th>
                <th style="width: 55px;">NIK Ibu</th>
                <th style="width: 55px;">Pekerjaan Ibu</th>
                <th style="width: 50px;">No HP Ibu</th>
                <th style="width: 90px;">Alamat Lengkap</th>
                <th style="width: 60px;">Nama Wali</th>
                <th style="width: 55px;">NIK Wali</th>
                <th style="width: 55px;">Pekerjaan Wali</th>
                <th style="width: 50px;">No HP Wali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nik_anak }}</td>
                <td>{{ $item->nama_lengkap_anak }}</td>
                <td>{{ ($item->tempat_lahir_anak ?? '-') . ', ' . ($item->tanggal_lahir_anak ? $item->tanggal_lahir_anak->format('d-m-Y') : '-') }}</td>
                <td>{{ $item->usia_label }}</td>
                <td>{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $item->agama ?? '-' }}</td>
                <td>{{ $item->nama_lengkap_ayah ?? '-' }}</td>
                <td>{{ $item->nik_ayah ?? '-' }}</td>
                <td>{{ $item->pekerjaan_ayah ?? '-' }}</td>
                <td>{{ $item->nomor_telepon_ayah ?? '-' }}</td>
                <td>{{ $item->nama_lengkap_ibu ?? '-' }}</td>
                <td>{{ $item->nik_ibu ?? '-' }}</td>
                <td>{{ $item->pekerjaan_ibu ?? '-' }}</td>
                <td>{{ $item->nomor_telepon_ibu ?? '-' }}</td>
                <td>{{ trim(($item->nama_jalan_rumah ?? '') . ' ' . ($item->kelurahan_rumah ?? '') . ' ' . ($item->kecamatan_rumah ?? '') . ' ' . ($item->kota_kabupaten_rumah ?? '') . ' ' . ($item->provinsi_rumah ?? '')) }}</td>
                <td>{{ $item->nama_lengkap_wali ?? '-' }}</td>
                <td>{{ $item->nik_wali ?? '-' }}</td>
                <td>{{ $item->pekerjaan_wali ?? '-' }}</td>
                <td>{{ $item->nomor_telepon_wali ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }} WIB</p>
    </div>
</body>
</html>
