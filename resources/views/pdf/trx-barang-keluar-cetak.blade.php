<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Barang Keluar #{{ $keluar->id_trx_brgkeluar }}</title>
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
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Detail Barang Keluar #{{ $keluar->id_trx_brgkeluar }}</h2>

    <table>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $keluar->barang->nama_barang }}</td>
        </tr>
        <tr>
            <th>Tanggal Keluar</th>
            <td>{{ \Carbon\Carbon::parse($keluar->tanggal_keluar)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Admin</th>
            <td>{{ $keluar->admin->nama_admin }}</td>
        </tr>
        <tr>
            <th>Jumlah Keluar</th>
            <td>{{ $keluar->jumlah_brgkeluar }}</td>
        </tr>
        <tr>
            <th>Harga Satuan</th>
            <td>Rp {{ number_format($keluar->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>Rp {{ number_format($keluar->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>

</html>
