<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2,
        p {
            text-align: center;
            margin: 0;
        }

        p {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi Barang</h2>
    <p>{{ $filterLabel }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th class="text-right">Stok Awal</th>
                <th class="text-right">Total Masuk</th>
                <th class="text-right">Total Keluar</th>
                <th class="text-right">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $brg)
                <tr>
                    <td>{{ $brg->nama_barang }}</td>
                    <td class="text-right">{{ $brg->stok_awal }}</td>
                    <td class="text-right">{{ $brg->total_masuk }}</td>
                    <td class="text-right">{{ $brg->total_keluar }}</td>
                    <td class="text-right">{{ $brg->stok_akhir }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
