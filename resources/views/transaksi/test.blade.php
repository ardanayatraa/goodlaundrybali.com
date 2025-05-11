<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
        }

        .nota-info {
            margin-bottom: 20px;
        }

        .nota-info p {
            margin: 5px 0;
        }

        .nota-items table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .nota-items th,
        .nota-items td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .nota-items th {
            background-color: #f4f4f4;
        }

        .footer {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="logo.png" alt="Logo Perusahaan">
            <h3>NOTA PEMBELIAN</h3>
        </div>

        <div class="nota-info">
            <p><strong>Nomor Transaksi:</strong> 123456789</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p><strong>Pelanggan:</strong> John Doe</p>
            <p><strong>Alamat:</strong> Jl. Raya No. 123, Bali</p>
            <p><strong>Metode Pembayaran:</strong> Kartu Kredit</p>
        </div>

        <div class="nota-items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Produk A</td>
                        <td>Rp 50,000</td>
                        <td>2</td>
                        <td>Rp 100,000</td>
                    </tr>
                    <tr>
                        <td>Produk B</td>
                        <td>Rp 75,000</td>
                        <td>1</td>
                        <td>Rp 75,000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="nota-info">
            <p><strong>Subtotal:</strong> Rp 175,000</p>
            <p><strong>Diskon:</strong> Rp 15,000</p>
            <p><strong>Total:</strong> Rp 160,000</p>
        </div>

        <div class="footer">
            Terima kasih atas kunjungan Anda!
        </div>
    </div>

</body>

</html>
