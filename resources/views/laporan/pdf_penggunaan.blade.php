<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penggunaan Laboratorium</title>
    <style>
        /* Gaya dasar untuk tampilan di layar (Web) */
        body { font-family: Arial, sans-serif; padding: 20px; color: #333; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        
        .section-title { font-size: 16px; font-weight: bold; margin: 20px 0 10px 0; background: #eee; padding: 5px; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #999; padding: 8px; font-size: 12px; }
        table.data-table th { background: #f2f2f2; }

        /* KUNCI: CSS KHUSUS PRINT - MEMASTIKAN PRINT RAPI */
        @media print {
            body > *:not(.print-container) { display: none !important; }
            .print-container, .print-container * { display: block !important; visibility: visible !important; }
            @page { size: A4; margin: 1cm; }
            body { margin: 0; padding: 0; }
            table { page-break-inside: auto !important; width: 100% !important; }
            tr { page-break-inside: avoid !important; page-break-after: auto !important; }
            thead { display: table-header-group !important; }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="header">
            <h1>Rekap Penggunaan Laboratorium</h1>
            <p>Periode: {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }} | Dicetak: {{ date('d F Y') }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px; table-layout: fixed;">
            <tr>
                <td style="border: 1px solid #94a3b8; padding: 12px; text-align: center; width: 33.33%;">
                    <div style="font-size: 9px; font-weight: bold; color: #475569; text-transform: uppercase;">JADWAL TETAP</div>
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; margin-top: 4px;">{{ collect($data)->where('tipe', 'Jadwal Rutin')->count() }}</div>
                </td>
                <td style="border: 1px solid #94a3b8; padding: 12px; text-align: center; width: 33.33%;">
                    <div style="font-size: 9px; font-weight: bold; color: #475569; text-transform: uppercase;">BOOKING</div>
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; margin-top: 4px;">{{ collect($data)->where('tipe', '!=', 'Jadwal Rutin')->count() }}</div>
                </td>
                <td style="border: 1px solid #94a3b8; padding: 12px; text-align: center; width: 33.33%;">
                    <div style="font-size: 9px; font-weight: bold; color: #475569; text-transform: uppercase;">TOTAL TERPAKAI</div>
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; margin-top: 4px;">{{ collect($data)->count() }}</div>
                </td>
            </tr>
        </table>

        <div class="section-title">Jadwal Tetap</div>
        <table class="data-table">
            <thead>
                <tr><th>Hari</th><th>Slot Waktu</th><th>Guru</th><th>Kelas</th><th>Mapel</th></tr>
            </thead>
            <tbody>
                @foreach(collect($data)->where('tipe', 'Jadwal Rutin') as $item)
                <tr>
                    <td>{{ $item['waktu'] }}</td><td>{{ $item['jam'] }}</td><td>{{ $item['pengguna'] }}</td>
                    <td>{{ $item['keterangan'] }}</td><td>{{ $item['agenda'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Booking Disetujui</div>
        <table class="data-table">
            <thead>
                <tr><th>Tanggal</th><th>Slot Waktu</th><th>Pengajar</th><th>Kelas</th><th>Kegiatan</th></tr>
            </thead>
            <tbody>
                @foreach(collect($data)->where('tipe', '!=', 'Jadwal Rutin') as $item)
                <tr>
                    <td>{{ $item['waktu'] }}</td><td>{{ $item['jam'] }}</td><td>{{ $item['pengguna'] }}</td>
                    <td>{{ $item['keterangan'] }}</td><td>{{ $item['agenda'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>