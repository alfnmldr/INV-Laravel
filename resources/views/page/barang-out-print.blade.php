<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar</title>
    <style>
        /* CSS untuk tampilan cetak */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Barang Keluar ({{ $range }})</h1>
    <table>
        <thead>
            <tr>
                <th>ID Barang Keluar</th>
                <th>ID Barang</th>
                <th>Waktu Keluar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluar as $barang)
                <tr>
                    <td>{{ $barang->id_barangkeluar }}</td>
                    <td>{{ $barang->id }}</td>
                    <td>{{ $barang->tgl_keluar }}</td>
                    <td>{{ $barang->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Menambahkan script untuk memicu cetak otomatis -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
