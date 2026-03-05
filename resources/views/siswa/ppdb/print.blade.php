<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Kelulusan PPDB - {{ $spmb->no_pendaftaran }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#6B46C1",
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Lexend', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white text-slate-900 min-h-screen p-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="bg-primary/10 p-3 rounded-xl">
                    <span class="material-symbols-outlined text-primary text-4xl">school</span>
                </div>
                <div class="text-left">
                    <h1 class="text-xl font-bold text-slate-800">Harapan Bangsa 2</h1>
                    <p class="text-xs text-slate-400 font-medium">Taman Kanak-Kanak</p>
                </div>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 mb-2">BUKTI KELULUSAN PPDB</h2>
            <p class="text-slate-600">Periode {{ $spmb->tahunAjaran?->tahun ?? date('Y') }}/{{ ($spmb->tahunAjaran?->tahun ?? date('Y')) + 1 }}</p>
        </div>

        <div class="bg-primary/5 border-2 border-primary/20 rounded-3xl p-8 mb-8">
            <div class="text-center mb-6">
                <span class="inline-flex px-4 py-2 rounded-full text-sm font-black bg-green-100 text-green-700 tracking-widest">
                    SELAMAT! ANDA DINYATAKAN LULUS
                </span>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                    <p class="text-lg font-bold text-slate-800">{{ $spmb->nama_lengkap_anak }}</p>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Pendaftaran</p>
                    <p class="text-lg font-bold text-slate-800">{{ $spmb->no_pendaftaran }}</p>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Registrasi</p>
                    <p class="text-lg font-bold text-slate-800">{{ $spmb->no_registrasi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">NIK</p>
                    <p class="text-lg font-bold text-slate-800">{{ $spmb->nik_anak }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 rounded-2xl p-6 mb-8">
            <h3 class="font-bold text-slate-800 mb-4">Catatan Daftar Ulang</h3>
            <p class="text-slate-600 leading-relaxed">
                @if($spmb->catatan_daftar_ulang)
                    {{ $spmb->catatan_daftar_ulang }}
                @else
                    Silahkan melakukan daftar ulang pada tanggal {{ $spmb->tanggal_mulai_daftar_ulang ? \Carbon\Carbon::parse($spmb->tanggal_mulai_daftar_ulang)->format('d-m-Y') : '10' }} - {{ $spmb->tanggal_selesai_daftar_ulang ? \Carbon\Carbon::parse($spmb->tanggal_selesai_daftar_ulang)->format('d-m-Y') : '15 Juli' }} di loket sekolah dengan membawa dokumen fisik asli (KK, Akta Kelahiran, dan Pas Foto 3x4).
                @endif
            </p>
        </div>

        <div class="text-center text-sm text-slate-500">
            <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            <p class="mt-2">Bukti ini wajib dibawa saat proses daftar ulang fisik ke sekolah.</p>
        </div>

        <div class="text-center mt-8 no-print">
            <button onclick="window.print()" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all">
                Cetak Bukti
            </button>
            <a href="{{ route('siswa.ppdb.hasil-seleksi') }}" class="ml-4 px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-all">
                Kembali
            </a>
        </div>
    </div>
</body>
</html>
