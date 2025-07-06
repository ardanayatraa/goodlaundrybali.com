{{-- resources/views/pdf/transaksi-cetak.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Laundry #{{ $transaksi->id_transaksi }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 8px;
        }

        .logo img {
            width: 80px;
        }

        h2 {
            text-align: center;
            margin: 0 0 4px;
        }

        .alamat {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .line {
            border-top: 1px solid #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        td,
        th {
            padding: 4px;
        }

        .info td:first-child {
            width: 30%;
            font-weight: bold;
            vertical-align: top;
        }

        .items th,
        .items td {
            border: 1px solid #000;
            text-align: center;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            margin-top: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    @php
        $path = public_path('assets/img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = base64_encode(file_get_contents($path));
        $logoSrc = "data:image/{$type};base64,{$data}";
    @endphp

    <div class="logo">
        <img src="{{ $logoSrc }}" alt="Logo Laundry" class="w-20">
    </div>


    <h2>GOOD LAUNDRY KEDONGANAN</h2>
    <div class="alamat">
        Jl. Raya Uluwatu, No. Kelan, Kedonganan,<br>
        Kec. Kuta, Kab. Badung, Bali 80363
    </div>

    <div class="line"></div>

    {{-- Informasi Transaksi --}}
    <table class="info">
        <tr>
            <td>Id Transaksi</td>
            <td>: {{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $transaksi->pelanggan->nama_pelanggan }}</td>
        </tr>
        <tr>
            <td>Point</td>
            <td>: {{ $transaksi->pelanggan->point }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $transaksi->pelanggan->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td>No. Telp</td>
            <td>: {{ $transaksi->pelanggan->no_telp ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status Pembayaran</td>
            <td>: {{ $transaksi->status_pembayaran }}</td>
        </tr>
        <tr>
            <td>Metode Bayar</td>
            <td>: {{ $transaksi->metode_pembayaran }}</td>
        </tr>
        <tr>
            <td>Keterangan (Qris)</td>
            <td>: {{ $transaksi->keterangan ?? '-' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    {{-- Detail Paket --}}
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Paket</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d->paket->jenis_paket }}</td>
                    <td>{{ $d->jumlah }}</td>
                    <td>Rp {{ number_format($d->paket->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Ringkasan --}}
    <table class="info">
        <tr>
            <td>Diskon</td>
            <td>: Rp {{ number_format($transaksi->detailTransaksi->sum('total_diskon'), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Bayar</strong></td>
            <td><strong>: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
        </tr>

        <tr>
            <td>Jumlah Bayar</td>
            <td>: Rp. {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembalian</td>
            <td>: Rp. {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="footer">
        ----- TERIMA KASIH -----
    </div>
</body>

</html>
