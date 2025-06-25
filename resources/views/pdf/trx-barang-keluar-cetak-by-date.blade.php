<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Barang Keluar {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h2>
        Detail Barang Keluar<br>
        <small>{{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM YYYY') }}</small>
    </h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Unit</th>
                <th>Admin</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $row)
                <tr>
                    <td>{{ $row->id_trx_brgkeluar }}</td>
                    <td>{{ $row->barang->nama_barang }}</td>
                    <td>{{ $row->barang->unit->nama_unit }}</td>
                    <td>{{ $row->admin->nama_admin }}</td>
                    <td>{{ $row->jumlah_brgkeluar }}</td>
                    <td>Rp {{ number_format($row->barang->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->barang->harga * $row->jumlah_brgkeluar, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
