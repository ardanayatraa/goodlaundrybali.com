<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi #{{ $transaksi->id_transaksi }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Detail Transaksi</h1>
        </div>
        <div class="content">
            <p><strong>ID Transaksi:</strong> {{ $transaksi->id_transaksi }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $transaksi->pelanggan->nama_pelanggan }}</p>
            <p><strong>Status:</strong> {{ $transaksi->status_transaksi }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->created_at }}</p>
        </div>
    </div>
</body>

</html>
