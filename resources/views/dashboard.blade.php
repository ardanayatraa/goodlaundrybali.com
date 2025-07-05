<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="container mx-auto px-4 py-3">
        {{ Breadcrumbs::render('dashboard') }}
    </div>

    {{-- A. DATA HARI INI --}}
    <div class="container mx-auto px-4 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">
            Data Hari Ini ({{ now()->toDateString() }})
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            {{-- Pelanggan Hari Ini --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-green-100">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Pelanggan</p>
                <h3 class="text-xl font-bold text-gray-800">
                    {{ number_format($pelangganHariIni) }}
                </h3>
            </div>

            {{-- Transaksi Hari Ini (Count) --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-purple-100">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Transaksi</p>
                <h3 class="text-xl font-bold text-gray-800">
                    {{ number_format($transaksiHariIniCount) }}
                </h3>
            </div>

            {{-- Transaksi Hari Ini (Nominal) --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-purple-100">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Nominal</p>
                <h3 class="text-lg font-bold text-gray-800">
                    Rp {{ number_format($transaksiHariIniNominal, 0, ',', '.') }}
                </h3>
            </div>

            {{-- Barang Masuk Hari Ini --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-blue-100">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Masuk</p>
                <h3 class="text-xl font-bold text-gray-800">
                    {{ number_format($totalBarangMasukHariIni) }}
                </h3>
                <p class="text-xs text-gray-600">
                    Rp {{ number_format($nominalMasukHariIni, 0, ',', '.') }}
                </p>
            </div>

            {{-- Barang Keluar Hari Ini --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-red-100">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8V4m0 0l4 4m-4-4l-4 4m-6 8v8m0 0l-4-4m4 4l4-4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Keluar</p>
                <h3 class="text-xl font-bold text-gray-800">
                    {{ number_format($totalBarangKeluarHariIni) }}
                </h3>
                <p class="text-xs text-gray-600">
                    Rp {{ number_format($nominalKeluarHariIni, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- B. DATA KESELURUHAN --}}
    <div class="container mx-auto px-4 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">
            Keseluruhan
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            {{-- Total Pelanggan --}}
            <a href="{{ route('pelanggan') }}"
                class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-green-100 group-hover:bg-green-200 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Pelanggan</p>
                <h3 class="text-xl font-bold text-gray-800">{{ number_format($totalPelanggan) }}</h3>
                <p class="text-xs {{ $growthPelanggan >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $growthPelanggan >= 0 ? '+' : '' }}{{ number_format($growthPelanggan, 2) }}%
                </p>
            </a>

            {{-- Pesanan Diproses & Baru --}}
            <a href="{{ route('transaksi') }}"
                class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-yellow-100 group-hover:bg-yellow-200 transition-colors">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Diproses</p>
                <h3 class="text-xl font-bold text-gray-800">{{ number_format($pesananDalamProses) }}</h3>
                <p class="text-xs text-yellow-600">{{ number_format($pesananBaru) }} baru</p>
            </a>

            {{-- Total Transaksi --}}
            <a href="{{ route('transaksi') }}"
                class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-purple-100 group-hover:bg-purple-200 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Total Transaksi</p>
                <h3 class="text-lg font-bold text-gray-800">
                    Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
                </h3>
                <p class="text-xs {{ $growthTransaksi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $growthTransaksi >= 0 ? '+' : '' }}{{ number_format($growthTransaksi, 2) }}%
                </p>
            </a>

            {{-- Barang Masuk Bulanan --}}
            <a href="{{ route('trx-barang-masuk') }}"
                class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Barang Masuk</p>
                <h3 class="text-xl font-bold text-gray-800">{{ number_format($totalBarangMasuk) }}</h3>
                <p class="text-xs text-gray-600">
                    Rp {{ number_format($nominalMasuk, 0, ',', '.') }}
                </p>
            </a>

            {{-- Barang Keluar Bulanan --}}
            <a href="{{ route('trx-barang-keluar') }}"
                class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow group">
                <div class="flex items-center justify-between mb-2">
                    <div class="p-2 rounded-lg bg-red-100 group-hover:bg-red-200 transition-colors">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8V4m0 0l4 4m-4-4l-4 4m-6 8v8m0 0l-4-4m4 4l4-4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-1">Barang Keluar</p>
                <h3 class="text-xl font-bold text-gray-800">{{ number_format($totalBarangKeluar) }}</h3>
                <p class="text-xs text-gray-600">
                    Rp {{ number_format($nominalKeluar, 0, ',', '.') }}
                </p>
            </a>
        </div>
    </div>

    {{-- Footer / Business Info --}}
    <div class="container mx-auto px-4 mb-6">
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="p-2 rounded-lg bg-white shadow-sm">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Good Laundry Kedonganan</h3>
                    <p class="text-xs text-gray-600">
                        Jl. Raya Uluwatu No. Kelan, Kec. Kuta, Badung, Bali 80363
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
