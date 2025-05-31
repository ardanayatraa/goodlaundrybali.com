<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 18px;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 80px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .alamat {
            text-align: center;
            font-size: 18px;
            margin-bottom: 15px;
        }

        hr {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td,
        th {
            padding: 5px;
            font-size: 18px;
        }

        .items th,
        .items td {
            border: 1px solid #ccc;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="logo">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Laundry">
    </div>

    <h2>GOOD LAUNDRY KEDONGANAN</h2>
    <div class="alamat">
        Jl. Raya Uluwatu, No. Kelan, Kedonganan,<br>
        Kec. Kuta, Kab. Badung, Bali 80363
    </div>
    <hr>

    <table>
        <tr>
            <td>Id Transaksi</td>
            <td>: {{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td>Tanggal Transaksi</td>
            <td>:
                {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->translatedFormat('l, d F Y') }}
            </td>
        </tr>
        <tr>
            <td>Nama Pelanggan</td>
            <td>: {{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Point</td>
            <td>: {{ $transaksi->pelanggan->point ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $transaksi->pelanggan->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td>No Telp</td>
            <td>: {{ $transaksi->pelanggan->no_telp ?? '-' }}</td>
        </tr>
        <tr>
            <td>Metode Pembayaran</td>
            <td>: {{ $transaksi->metode_pembayaran }}</td>
        </tr>
        <tr>
            <td>Status Pembayaran</td>
            <td>: {{ ucfirst($transaksi->status_pembayaran) }}</td>
        </tr>
        <tr>
            <td>Point Saat Ini</td>
            <td>: {{ $transaksi->pelanggan->point ?? '0' }}</td>
        </tr>
        <tr>
            <td>Keterangan (Qris)</td>
            <td>: {{ $transaksi->keterangan ?? '-' }}</td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Jenis Paket</th>
                <th>Unit</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $detail)
                <tr>
                    {{-- gunakan relasi detail->paket --}}
                    <td>{{ $detail->paket->jenis_paket }}</td>
                    <td>{{ $detail->paket->unitPaket->nama_unit ?? $detail->paket->unit }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp. {{ number_format($detail->paket->harga, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <td>Diskon</td>
            <td>: Rp. {{ number_format($transaksi->detailTransaksi->sum('total_diskon'), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Subtotal</strong></td>
            <td><strong>: Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        -----TERIMAKASIH-----
    </div>

</body>

</html>
