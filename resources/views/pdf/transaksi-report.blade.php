<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            /* Adjust font size to fit content */
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
            /* Ensure table fits within the page */
            word-wrap: break-word;
            /* Prevent text overflow */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
            /* Adjust font size */
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
        <h1 style="text-align: center;">Laporan Transaksi</h1>
        <p style="text-align: center; font-size: 12px;">
            Filter: {{ $filterDescription ?? 'Tidak ada filter yang dipilih' }}
        </p>

        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Paket</th>
                    <th>Tanggal Transaksi</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Transaksi</th>
                    <th>Jumlah Point</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $transaksi)
                    <tr>
                        <td>{{ $transaksi->id_transaksi }}</td>
                        <td>{{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
                        <td>{{ $transaksi->paket->jenis_paket }}</td>
                        <td>{{ $transaksi->created_at->format('Y-m-d') }}</td>
                        <td>{{ $transaksi->metode_pembayaran }}</td>
                        <td>{{ $transaksi->status_pembayaran }}</td>
                        <td>{{ $transaksi->status_transaksi }}</td>
                        <td>{{ $transaksi->jumlah_point }}</td>
                        <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @if (($index + 1) % 20 == 0)
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: left; font-weight: bold;">Total Harga (Lunas):</td>
                    <td>Rp
                        {{ number_format($data->where('status_pembayaran', 'Lunas')->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: left; font-weight: bold;">Total Harga (Belum Lunas):</td>
                    <td>Rp
                        {{ number_format($data->where('status_pembayaran', 'Belum Bayar')->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="page-break"></div>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Paket</th>
                    <th>Tanggal Transaksi</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Transaksi</th>
                    <th>Jumlah Point</th>
                </tr>
            </thead>
            <tbody>
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: left; font-weight: bold;">Total keuntungan :</td>
                    <td>Rp
                        {{ number_format($data->where('status_pembayaran', 'Lunas')->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align: left; font-weight: bold;">Total yang belum di bayarkan :</td>
                    <td>Rp
                        {{ number_format($data->where('status_pembayaran', 'Belum Bayar')->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
