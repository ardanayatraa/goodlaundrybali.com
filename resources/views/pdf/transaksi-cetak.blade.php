<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi #{{ $transaksi->id_transaksi }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
        }

        /* ulang header tiap halaman */
        tbody {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Detail Transaksi #{{ $transaksi->id_transaksi }}</h2>
        <p>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</p>
    </div>

    {{-- Meta --}}
    <table class="meta">
        <tr>
            <td><strong>Pelanggan</strong></td>
            <td>{{ $transaksi->pelanggan->nama_pelanggan }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Paket</strong></td>
            <td>{{ $transaksi->paket->jenis_paket }}</td>
        </tr>
        <tr>
            <td><strong>Harga Paket</strong></td>
            <td>Rp {{ number_format($transaksi->paket->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Unit Paket</strong></td>
            <td>{{ $transaksi->paket->unitPaket->nama_unit ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Waktu Pengerjaan</strong></td>
            <td>{{ $transaksi->paket->waktu_pengerjaan }}</td>
        </tr>
        <tr>
            <td><strong>Total Harga</strong></td>
            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Point</strong></td>
            <td>{{ $transaksi->jumlah_point }}</td>
        </tr>
    </table>

    <br />

    {{-- Mulai tabel detail ambil --}}
    @php $perPage = 10; @endphp
    @foreach ($transaksi->detailTransaksi as $idx => $d)
        {{-- Jika idx=0 atau setiap kelipatan $perPage, buka <table> baru --}}
        @if ($idx % $perPage === 0)
            @if ($idx > 0)
                </tbody>
                </table>
                <div class="page-break"></div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Ambil</th>
                        <th>Jam Ambil</th>
                        <th>Jumlah</th>
                        <th>Total Diskon</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
        @endif

        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($d->tanggal_ambil)->format('d M Y') }}</td>
            <td>{{ $d->jam_ambil }}</td>
            <td>{{ $d->jumlah }}</td>
            <td>Rp {{ number_format($d->total_diskon, 0, ',', '.') }}</td>
            <td>{{ $d->keterangan }}</td>
        </tr>

        {{-- Jika baris terakhir di halaman --}}
        @if (($idx + 1) % $perPage === 0 || $loop->last)
            </tbody>
            </table>
        @endif
    @endforeach
</body>

</html>
