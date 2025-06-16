{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    {{-- Breadcrumbs --}}
    <div class="container mx-auto px-6 py-4">
        {{ Breadcrumbs::render('dashboard') }}
    </div>

    {{-- Grid utama: 1–5 kolom adaptif --}}
    <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6">

        {{-- 1. Pelanggan (Hijau Muda) --}}
        <div
            class="rounded-xl shadow-sm p-6 transform hover:-translate-y-1 hover:shadow-lg transition duration-200 bg-green-50">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-700">Pelanggan</span>
            </div>
            <h3 class="text-2xl font-bold text-green-800">{{ number_format($totalPelanggan) }}</h3>
            <p class="mt-2 text-sm {{ $growthPelanggan >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $growthPelanggan >= 0 ? '+' : '' }}{{ number_format($growthPelanggan, 2) }}%
            </p>
        </div>

        {{-- 2. Pesanan Diproses (Kuning Muda) --}}
        <div
            class="rounded-xl shadow-sm p-6 transform hover:-translate-y-1 hover:shadow-lg transition duration-200 bg-yellow-50">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a6 6 0 0112 0v-1" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-yellow-700">Pesanan Diproses</span>
            </div>
            <h3 class="text-2xl font-bold text-yellow-800">{{ number_format($pesananDalamProses) }}</h3>
            <p class="mt-2 text-sm text-yellow-600">{{ number_format($pesananBaru) }} baru</p>
        </div>

        {{-- 3. Total Transaksi (Ungu Muda) --}}
        <div
            class="rounded-xl shadow-sm p-6 transform hover:-translate-y-1 hover:shadow-lg transition duration-200 bg-purple-50">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-purple-700">Total Transaksi</span>
            </div>
            <h3 class="text-2xl font-bold text-purple-800">
                Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
            </h3>
            <p class="mt-2 text-sm {{ $growthTransaksi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $growthTransaksi >= 0 ? '+' : '' }}{{ number_format($growthTransaksi, 2) }}%
            </p>
        </div>

        {{-- 4. Barang Masuk (Biru Muda) --}}
        <div
            class="rounded-xl shadow-sm p-6 transform hover:-translate-y-1 hover:shadow-lg transition duration-200 bg-blue-50">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h18M9 3v18m6-18v18M5 9h14" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-blue-700">Barang Masuk</span>
            </div>
            <h3 class="text-2xl font-bold text-blue-800">{{ number_format($totalBarangMasuk) }}</h3>
            <p class="mt-2 text-sm text-blue-600">Bulan ini</p>
            <p class="mt-1 text-sm font-medium text-blue-700">
                Rp {{ number_format($nominalMasuk, 0, ',', '.') }}
            </p>
        </div>

        {{-- 5. Barang Keluar (Merah Muda) --}}
        <div
            class="rounded-xl shadow-sm p-6 transform hover:-translate-y-1 hover:shadow-lg transition duration-200 bg-red-50">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-red-100">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-red-700">Barang Keluar</span>
            </div>
            <h3 class="text-2xl font-bold text-red-800">{{ number_format($totalBarangKeluar) }}</h3>
            <p class="mt-2 text-sm text-red-600">Bulan ini</p>
            <p class="mt-1 text-sm font-medium text-red-700">
                Rp {{ number_format($nominalKeluar, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Footer / Business Info --}}
    <div class="container mx-auto px-6 mt-8">
        <div
            class="rounded-xl shadow-sm p-6 transform hover:-translate-y-1 hover:shadow-lg transition duration-200 bg-indigo-50">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-lg bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Good Laundry Kedonganan</h3>
                    <p class="text-sm text-gray-600">
                        Jl. Raya Uluwatu No. Kelan, Kedonganan, Kec. Kuta, Badung, Bali 80363
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
