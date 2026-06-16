<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventaris Laboratorium</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; color: #333; font-size: 12px; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0 0 4px 0; font-size: 18px; }
        .header p { margin: 0; color: #555; font-size: 11px; }

        .lab-title { font-size: 14px; font-weight: bold; background: #eee; padding: 6px 10px; margin: 20px 0 8px 0; border-left: 4px solid #333; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table th, table td { border: 1px solid #999; padding: 6px 8px; font-size: 11px; }
        table th { background: #f2f2f2; font-weight: bold; text-align: left; }

        .badge-baik     { color: #166534; background: #dcfce7; padding: 2px 6px; border-radius: 4px; font-weight: bold; }
        .badge-rusak    { color: #991b1b; background: #fee2e2; padding: 2px 6px; border-radius: 4px; font-weight: bold; }
        .badge-cadangan { color: #92400e; background: #fef3c7; padding: 2px 6px; border-radius: 4px; font-weight: bold; }

        .footer { margin-top: 30px; border-top: 1px solid #ccc; padding-top: 8px; font-size: 10px; color: #888; display: flex; justify-content: space-between; }

        @media print {
            @page { size: A4; margin: 1cm; }
            body { margin: 0; padding: 0; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; }
            thead { display: table-header-group; }
            .lab-title { page-break-before: auto; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Inventaris Laboratorium</h1>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }}</p>
    </div>

    @foreach($labs as $lab)
        <div class="lab-title">{{ $lab->nama_lab }} — Ready: {{ $lab->komputer_ready ?? 0 }} PC</div>

        @if($lab->inventaris->isEmpty())
            <p style="color: #888; font-style: italic; margin-bottom: 16px;">Tidak ada data inventaris untuk laboratorium ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Barang</th>
                        <th style="width: 10%; text-align: center;">Baik</th>
                        <th style="width: 10%; text-align: center;">Rusak</th>
                        <th style="width: 12%; text-align: center;">Cadangan</th>
                        <th style="width: 10%; text-align: center;">Total</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lab->inventaris as $i => $item)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td style="text-align: center;"><span class="badge-baik">{{ $item->baik }}</span></td>
                        <td style="text-align: center;"><span class="badge-rusak">{{ $item->rusak }}</span></td>
                        <td style="text-align: center;"><span class="badge-cadangan">{{ $item->cadangan }}</span></td>
                        <td style="text-align: center; font-weight: bold;">{{ $item->total ?? ($item->baik + $item->rusak + $item->cadangan) }}</td>
                        <td style="color: #555;">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    <div class="footer">
        <span>Lab Management | MA Unggulan Nuris</span>
        <span>Laporan Inventaris Laboratorium</span>
    </div>
</body>
</html>