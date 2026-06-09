<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penggunaan Lab</h1>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lab</th>
                <th>Peminjam</th>
                <th>Tanggal</th>
            </tr>
        </thead>
       <tbody>
    @foreach($data as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->lab->nama_lab }}</td>
        
        <td>{{ $item->nama_pemohon }} ({{ $item->tipe_pemohon }})</td>
        
        <td>{{ $item->tanggal_booking }}</td>
    </tr>
    @endforeach
</tbody>
    </table>

    <div style="margin-top: 50px; float: right; text-align: center;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>Kepala Laboratorium</p>
    </div>
</body>
</html>