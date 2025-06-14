<x-app-layout>
    {{ Breadcrumbs::render('dashboard') }}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pelanggan -->
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-400">Pelanggan</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalPelanggan) }}</h3>
            <p class="text-sm text-green-500 mt-2">
                @if ($growthPelanggan >= 0)
                    +{{ number_format($growthPelanggan, 2) }}% dari bulan lalu
                @else
                    {{ number_format($growthPelanggan, 2) }}% dari bulan lalu
                @endif
            </p>
        </div>

        <!-- Pesanan -->
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a6 6 0 01-12 0v-1" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-400">Pesanan Diproses</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($pesananDalamProses) }}</h3>
            <p class="text-sm text-yellow-500 mt-2">{{ number_format($pesananBaru) }} pesanan baru bulan ini</p>
        </div>

        <!-- Transaksi -->
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-400">Total Transaksi</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</h3>
        </div>

        <!-- Barang Masuk -->
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h18M9 3v18m6-18v18M5 9h14" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-400">Barang Masuk</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalBarangMasuk) }}</h3>
            <p class="text-sm text-blue-500 mt-2">Bulan ini</p>
        </div>

        <!-- Barang Keluar -->
        <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.5s">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-red-100">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-400">Barang Keluar</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalBarangKeluar) }}</h3>
            <p class="text-sm text-red-500 mt-2">Bulan ini</p>
        </div>
    </div>

    <!-- Business Info -->
    <div class="mt-8 bg-white rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.6s">
        <div class="flex items-center space-x-4">
            <div class="p-3 rounded-lg bg-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Good Laundry Kedonganan</h3>
                <p class="text-sm text-gray-600">Jl. Raya Uluwatu, No. Kelan, Kedonganan, Kec. Kuta, Kab. Badung, Bali
                    80363</p>
            </div>
        </div>
    </div>
</x-app-layout>
