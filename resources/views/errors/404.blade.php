<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-green': '#2ecc71',
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h1 class="text-9xl font-extrabold text-custom-green">404</h1>
            <p class="mt-2 text-3xl font-semibold text-gray-900">Halaman Tidak Ditemukan</p>
            <p class="mt-2 text-sm text-gray-500">Maaf, kami tidak dapat menemukan halaman yang Anda cari.</p>
        </div>
        <div class="mt-8 space-y-4">
            <a href="/" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-custom-green hover:bg-green-600 transition duration-150 ease-in-out">
                Kembali ke Beranda
            </a>
        
        </div>
    </div>
    <footer class="absolute bottom-4 left-4 right-4 text-center text-gray-400 text-sm">
        © 2025 Good Laundry Kedonganan. Semua hak dilindungi.
    </footer>
</body>
</html>