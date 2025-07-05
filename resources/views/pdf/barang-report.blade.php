<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 4px;
        }

        th {
            background: #eee;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center">Laporan Stok Barang</h2>

    <p>Filter: {{ $filterDesc }}</p>

    <table>
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Nama Barang</th>
                <th class="text-right">Stok Awal</th>
                <th class="text-right">Masuk</th>
                <th class="text-right">Keluar</th>
                <th class="text-right">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockSummary as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-right">{{ $item->stok_awal }}</td>
                    <td class="text-right">{{ $item->masuk }}</td>
                    <td class="text-right">{{ $item->keluar }}</td>
                    <td class="text-right">{{ $item->stok_akhir }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">TOTAL</th>
                <th class="text-right">{{ $totalAwal }}</th>
                <th class="text-right">{{ $totalMasuk }}</th>
                <th class="text-right">{{ $totalKeluar }}</th>
                <th class="text-right">{{ $totalAkhir }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
