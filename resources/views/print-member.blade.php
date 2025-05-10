<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kartu Member</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- html2canvas -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        @page {
            size: 85.6mm 54mm;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: transparent;
            min-height: 100vh;
        }

        .card-size {
            width: 161.2mm;
            /* sebelumnya 85.6mm */
            height: 98mm;
            /* sebelumnya 54mm */
        }

        .no-print {
            display: none;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                width: 85.6mm;
                height: 54mm;
            }

            .print-container {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        .card-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="print-container min-h-screen w-full flex flex-col items-center justify-center p-4">
        <!-- Card Container with Responsive Centering -->
        <div class="max-w-xl w-full flex flex-col items-center justify-center">
            <!-- Card -->
            <div id="card-container"
                class="card-size bg-green-500 rounded-xl overflow-hidden p-4 text-white font-sans relative shadow-lg card-pattern">

                <!-- Title -->
                <div class="text-center relative z-10">
                    <h1 class="text-xl font-bold uppercase tracking-wider">Good Laundry</h1>
                    <p class="text-xs">Member</p>
                </div>

                <!-- Divider -->
                <div class="border-t border-white/30 my-2"></div>

                <!-- Data Table -->
                <div class="bg-white/10 rounded-lg p-2.5">
                    <table class="w-full text-sm">
                        <tr>
                            <th class="text-left py-1 font-medium text-white/90">ID Pelanggan</th>
                            <td class="py-1 font-semibold">{{ $pelanggan->id_pelanggan }}</td>
                        </tr>
                        <tr class="border-t border-white/10">
                            <th class="text-left py-1 font-medium text-white/90">Nama</th>
                            <td class="py-1 font-semibold">{{ $pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr class="border-t border-white/10">
                            <th class="text-left py-1 font-medium text-white/90">Telepon</th>
                            <td class="py-1 font-semibold">{{ $pelanggan->no_telp }}</td>
                        </tr>
                        <tr class="border-t border-white/10">
                            <th class="text-left py-1 font-medium text-white/90">Bergabung</th>
                            <td class="py-1 font-semibold">
                                {{ \Carbon\Carbon::parse($pelanggan->created_at)->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>

            </div>

            <!-- Buttons - Responsive Layout -->
            <div class="flex flex-wrap justify-center gap-3 mt-6 no-print">
                <button onclick="history.back()"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow flex items-center gap-2 transition-colors">
                    <i class="fas fa-arrow-left"></i><span>Kembali</span>
                </button>
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow flex items-center gap-2 transition-colors">
                    <i class="fas fa-print"></i><span>Cetak</span>
                </button>
                <button onclick="downloadAsImage()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow flex items-center gap-2 transition-colors">
                    <i class="fas fa-download"></i><span>Download Gambar</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function downloadAsImage() {
            const card = document.getElementById('card-container');
            html2canvas(card, {
                scale: 3,
                useCORS: true,
                backgroundColor: null
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `kartu-member-{{ $pelanggan->id_pelanggan }}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
</body>

</html>
