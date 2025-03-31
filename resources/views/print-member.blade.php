<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Card</title>
    <style>
        @page {
            size: 85.6mm 54mm;
            margin: 0;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f3f4f6;
        }

        .card {
            width: 85.6mm;
            height: 54mm;
            background: #e9d8fd;
            border-radius: 8px;
            border: 2px solid #9f7aea;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }

        .info {
            font-size: 10px;
            color: #444;
            line-height: 1.5;
        }

        .box {
            display: inline-block;
            background: white;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: bold;
            box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            font-size: 8px;
            color: #555;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card">
        <!-- Header -->
        <div class="header">CUSTOMER CARD</div>

        <!-- Informasi Pelanggan -->
        <div class="info">
            <p>ID Pelanggan: <span class="box">{{ $pelanggan->id_pelanggan }}</span></p>
            <p>Nama: <span class="box">{{ $pelanggan->nama_pelanggan }}</span></p>
            <p>Telepon: <span class="box">{{ $pelanggan->no_telp }}</span></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>GOOD LAUNDRY - KEDONGANAN</p>
            <p>Jl. Raya Uluwatu, Kelan, Kedonganan, Kuta, Badung, Bali.</p>
        </div>
    </div>
</body>

</html>
