<table border="1">
    <thead>
        <tr>
            <th>Lab</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($labs as $lab)
            @foreach($lab->inventaris as $item)
            <tr>
                <td>{{ $lab->nama_lab }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->kondisi }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<button onclick="window.print()">Cetak / Print ke PDF</button>