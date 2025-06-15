<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">Laporan Barang</h1>
        <p style="text-align: center; font-size: 12px;">
            Filter: {{ $filterDescription ?? 'Tidak ada filter yang dipilih' }}
        </p>

        <!-- Section: Data Barang -->
        <h2 style="text-align: left; margin-top: 20px;">Data Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah Masuk</th>
                    <th>Jumlah Keluar</th>
                    <th>Stok Awal</th>
                    <th>Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report as $index => $row)
                    <tr>
                        <td>{{ $row['nama'] }}</td>
                        <td>Rp {{ number_format($row['harga'], 0, ',', '.') }}</td>
                        <td>{{ $row['jumlah_masuk'] }}</n` <td>{{ $row['jumlah_keluar'] }}</n` <td>
                            {{ $row['stok_awal'] }}</n` <td>{{ $row['stok_akhir'] }}</td>
                    </tr>

                    @if (($index + 1) % 20 == 0)
            </tbody>
        </table>
        <div class="page-break"></div> <!-- Page break after every 20 rows -->
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah Masuk</th>
                    <th>Jumlah Keluar</th>
                    <th>Stok Awal</th>
                    <th>Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                @endif
                @endforeach

                <!-- Footer: Summary -->
                <tr style="font-weight: bold; background-color: #f9f9f9;">
                    <td colspan="2" style="text-align: left;">Total Keseluruhan:</td>
                    <td>{{ collect($report)->sum('jumlah_masuk') }}</td>
                    <td>{{ collect($report)->sum('jumlah_keluar') }}</td>
                    <td>{{ collect($report)->sum('stok_awal') }}</td>
                    <td>{{ collect($report)->sum('stok_akhir') }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</body>

</html>
