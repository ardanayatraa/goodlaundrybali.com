<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Aturan untuk media print */
        @media print {
            body {
                background-color: white;
                color: black;
            }

            .bg-violet-200 {
                background-color: #e9d8fd; /* Sesuaikan warna dengan yang diinginkan */
            }

            .w-full {
                width: 100%;
            }

            .p-6 {
                padding: 16px;
            }

            .rounded-lg {
                border-radius: 8px;
            }

            .space-y-2 {
                margin-bottom: 12px;
            }

            .mx-2 {
                margin-left: 8px;
                margin-right: 8px;
            }

            .flex-1 {
                flex-grow: 1;
            }

            .flex {
                display: flex;
            }

            .text-xl, .text-lg, .text-sm {
                font-size: 16px;
            }

            /* Hapus gambar saat mencetak jika perlu */
            img {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-80">
        <!-- Customer Information Card -->
        <div class="w-full p-6 rounded-lg bg-violet-200">
            <h2 class="text-xl font-bold mb-4">CUSTOMER CARD</h2>
            <div class="space-y-2">
                <div class="flex items-center">
                    <span class="w-32 font-semibold">ID Pelanggan</span>
                    <span class="mx-2">:</span>
                    <div class="flex-1 p-1 bg-white rounded">{{ $pelanggan->id_pelanggan }}</div>
                </div>
                <div class="flex items-center">
                    <span class="w-32 font-semibold">Nama Pelanggan</span>
                    <span class="mx-2">:</span>
                    <div class="flex-1 p-1 bg-white rounded">{{ $pelanggan->nama_pelanggan }}</div>
                </div>
                <div class="flex items-center">
                    <span class="w-32 font-semibold">Nomor Telepon</span>
                    <span class="mx-2">:</span>
                    <div class="flex-1 p-1 bg-white rounded">{{ $pelanggan->no_telp }}</div>
                </div>
            </div>
        </div>
        
        <!-- Laundry Information (Back Side) -->
        <div class="w-full p-6 rounded-lg bg-violet-200 mt-4">
            <div class="text-center space-y-2">
                <h2 class="text-lg font-bold">GOOD LAUNDRY</h2>
                <h3 class="text-lg font-bold">KEDONGANAN</h3>
                <div class="flex justify-center my-2">
                    <img 
                        src="https://cdn-icons-png.flaticon.com/512/2975/2975175.png" 
                        alt="Laundry Icon"
                        class="w-16 h-16"
                    />
                </div>
                <p class="text-sm">
                    Jl. Raya Uluwatu, Kelan, Kedonganan,<br>
                    Kuta, Badung, Bali.
                </p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.close();
        }
    </script>
</body>
</html>
