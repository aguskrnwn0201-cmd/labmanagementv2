<div class="print-container">
    <div class="print-header">
        <h2>LAPORAN INVENTARIS AKSES FASILITAS LABORATORIUM</h2>
        <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th rowspan="2">Nama Lab</th>
                <th rowspan="2">Komputer Ready</th>
                <th rowspan="2">Nama Barang / Aset</th>
                <th colspan="3" class="text-center">Kondisi Unit</th>
                <th rowspan="2">Total Stok</th>
            </tr>
            <tr>
                <th class="text-center text-green">Baik</th>
                <th class="text-center text-red">Rusak</th>
                <th class="text-center text-amber">Cadangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labs as $lab)
                @forelse($lab->inventaris as $index => $item)
                <tr>
                    {{-- Menggabungkan baris nama lab agar tidak berulang (Spanning) --}}
                    @if($index === 0)
                        <td rowspan="{{ $lab->inventaris->count() }}" class="font-bold">
                            {{ $lab->nama_lab }}
                        </td>
                        <td rowspan="{{ $lab->inventaris->count() }}" class="text-center font-bold">
                            {{ $lab->komputer_ready ?? 0 }} Unit
                        </td>
                    @endif
                    
                    <td>{{ $item->nama_barang }}</td>
                    <td class="text-center text-green">{{ $item->baik }}</td>
                    <td class="text-center text-red">{{ $item->rusak }}</td>
                    <td class="text-center text-amber">{{ $item->cadangan }}</td>
                    <td class="text-center font-bold bg-gray">
                        {{ $item->total ?? ($item->baik + $item->rusak + $item->cadangan) }}
                    </td>
                </tr>
                @empty
                {{-- Jika Lab Belum Memiliki Inventaris Sama Sekali --}}
                <tr>
                    <td class="font-bold">{{ $lab->nama_lab }}</td>
                    <td class="text-center font-bold">{{ $lab->komputer_ready ?? 0 }} Unit</td>
                    <td colspan="5" class="text-center italic text-muted">Belum ada aset terdaftar di lab ini.</td>
                </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>

    <div class="print-action">
        <button onclick="window.print()">
            <span>🖨️</span> Cetak / Save ke PDF
        </button>
    </div>
</div>

{{-- Style Khusus Cetak Agar Hasil Kertas/PDF Rapih Bersih --}}
<style>
    .print-container {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #222;
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .print-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 3px double #333;
        padding-bottom: 10px;
    }
    .print-header h2 {
        margin: 0 0 5px 0;
        font-size: 22px;
        letter-spacing: 0.5px;
    }
    .print-header p {
        margin: 0;
        font-size: 13px;
        color: #666;
    }
    .print-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-size: 13px;
    }
    .print-table th, .print-table td {
        border: 1px solid #444;
        padding: 10px 12px;
        text-align: left;
    }
    .print-table th {
        background-color: #f5f5f5;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    .text-center { text-align: center !important; }
    .font-bold { font-weight: bold; }
    .italic { font-style: italic; }
    .text-muted { color: #888; }
    .bg-gray { background-color: #fafafa; }
    
    /* Indikator Warna Teks Tipis */
    .text-green { color: #1e7e34; font-weight: 500; }
    .text-red { color: #bd2130; font-weight: 500; }
    .text-amber { color: #d39e00; font-weight: 500; }

    .print-action {
        display: flex;
        justify-content: flex-end;
    }
    .print-action button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .print-action button:hover { background-color: #0056b3; }

    /* CSS Magic: Menyembunyikan tombol cetak saat kertas/PDF di-print */
    @media print {
        body { background: white; color: black; padding: 0; }
        .print-container { max-width: 100%; padding: 0; }
        .print-action { display: none !important; }
        .print-table th { background-color: #f5f5f5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>