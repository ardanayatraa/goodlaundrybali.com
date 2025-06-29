<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pelanggan Member</title>
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

        .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">Laporan Pelanggan Member</h1>
        <p style="text-align: center; font-size: 12px;">
            Periode: {{ request('filterStartDate') ?? '-' }} s/d {{ request('filterEndDate') ?? '-' }}
        </p>

        @php
            $perPage = 25;
            $chunkedData = $data->chunk($perPage);
            $globalRowNumber = 1;
        @endphp

        @foreach ($chunkedData as $chunkIndex => $chunk)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Harga Pendaftaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chunk as $index => $pelanggan)
                        <tr>
                            <td>{{ $globalRowNumber++ }}</td>
                            <td>{{ $pelanggan->nama_pelanggan }}</td>
                            <td>{{ \Carbon\Carbon::parse($pelanggan->created_at)->format('d-m-Y') }}</td>
                            <td>Rp 10.000</td>
                        </tr>
                    @endforeach

                    {{-- Baris total di halaman terakhir --}}
                    @if ($chunkIndex === $chunkedData->count() - 1)
                        <tr class="total-row">
                            <td colspan="3" class="text-right">Total Harga Pendaftaran</td>
                            <td>Rp {{ number_format($data->count() * 10000, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>

</html>
