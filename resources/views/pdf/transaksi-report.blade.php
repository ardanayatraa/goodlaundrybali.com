<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
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
        <h1 style="text-align: center;">Laporan Transaksi</h1>
        <p style="text-align: center; font-size: 12px;">
            Filter: {{ $filterDescription ?? 'Tidak ada filter yang dipilih' }}
        </p>

        @php
            $perPage = 20;
            $chunkedData = $data->chunk($perPage);
        @endphp

        @foreach ($chunkedData as $chunk)
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
                    @foreach ($chunk as $transaksi)
                        <tr>
                            <td>{{ $transaksi->id_transaksi }}</td>
                            <td>{{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td>
                                @foreach ($transaksi->detailTransaksi as $detail)
                                    {{ $detail->paket->jenis_paket ?? '-' }}<br>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d') }}</td>
                            <td>{{ $transaksi->metode_pembayaran }}</td>
                            <td>{{ $transaksi->status_pembayaran }}</td>
                            <td>{{ $transaksi->status_transaksi }}</td>
                            <td>{{ $transaksi->jumlah_point }}</td>
                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8" style="text-align: left; font-weight: bold;">Total Harga (Lunas):</td>
                        <td>
                            Rp
                            {{ number_format($data->where('status_pembayaran', 'Lunas')->sum('total_harga'), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: left; font-weight: bold;">Total Harga (Belum Lunas):</td>
                        <td>
                            Rp
                            {{ number_format($data->where('status_pembayaran', 'Belum Bayar')->sum('total_harga'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>

</html>
