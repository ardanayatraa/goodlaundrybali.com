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
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Unit</th>
                    <th>Tanggal Dibuat</th>
                    <th>Stok</th>
                    <th>Jumlah Barang Masuk</th>
                    <th>Jumlah Barang Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $barang)
                    <tr>
                        <td>{{ $barang->id_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>{{ $barang->unit->nama_unit ?? '-' }}</td>
                        <td>{{ $barang->created_at->format('Y-m-d') }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>{{ $barang->trxBarangMasuk->pluck('jumlah_brgmasuk')->implode(', ') ?? '-' }}</td>
                        <td>{{ $barang->trxBarangKeluar->pluck('jumlah_brgkeluar')->implode(', ') ?? '-' }}</td>
                    </tr>
                    @if (($index + 1) % 20 == 0)
            </tbody>
        </table>
        <div class="page-break"></div> <!-- Page break after every 20 rows -->
        <table>
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Unit</th>
                    <th>Tanggal Dibuat</th>
                    <th>Stok</th>
                    <th>Jumlah Barang Masuk</th>
                    <th>Jumlah Barang Keluar</th>
                </tr>
            </thead>
            <tbody>
                @endif
                @endforeach
                <tr style="font-weight: bold; background-color: #f9f9f9;">
                    <td colspan="4" style="text-align: left;">Total Barang (Stok):</td>
                    <td></td>
                    <td>{{ $data->sum('stok') }}</td>
                    <td>{{ $data->sum(fn($item) => $item->trxBarangMasuk->sum('jumlah_brgmasuk')) }}</td>
                    <td>{{ $data->sum(fn($item) => $item->trxBarangKeluar->sum('jumlah_brgkeluar')) }}</td>
                </tr>
                <tr style="font-weight: bold; background-color: #f9f9f9;">
                    <td colspan="4" style="text-align: left;">Total Nilai:</td>
                    <td></td>
                    <td>Rp {{ number_format($data->sum(fn($item) => $item->harga * $item->stok), 0, ',', '.') }}</td>
                    <td>Rp
                        {{ number_format($data->sum(fn($item) => $item->harga * $item->trxBarangMasuk->sum('jumlah_brgmasuk')), 0, ',', '.') }}
                    </td>
                    <td>Rp
                        {{ number_format($data->sum(fn($item) => $item->harga * $item->trxBarangKeluar->sum('jumlah_brgkeluar')), 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
