<table border="1" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>Lab</th>
            <th>Pelapor</th>
            <th>Kerusakan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporans as $laporan)
        <tr>
            <td>{{ $laporan->lab->nama_lab }}</td>
            <td>{{ $laporan->nama_pelapor }}</td>
            <td>{{ $laporan->jenis_kerusakan }}</td>
            <td>{{ $laporan->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>