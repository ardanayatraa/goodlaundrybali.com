<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Barang Masuk #{{ $masuk->id_trx_brgmasuk }}</title>
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
    <h2>Detail Barang Masuk #{{ $masuk->id_trx_brgmasuk }}</h2>

    <table>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $masuk->barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Unit Barang</th>
            <td>{{ $masuk->barang->unit->nama_unit }}</td>
        </tr>
        <tr>
            <th>Tanggal Masuk</th>
            <td>{{ \Carbon\Carbon::parse($masuk->tanggal_masuk)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Admin</th>
            <td>{{ $masuk->admin->nama_admin }}</td>
        </tr>
        <tr>
            <th>Jumlah Masuk</th>
            <td>{{ $masuk->jumlah_brgmasuk }}</td>
        </tr>
        <tr>
            <th>Harga Satuan</th>
            <td>Rp {{ number_format($masuk->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp {{ number_format($masuk->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>

</html>
