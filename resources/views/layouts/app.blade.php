<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>


    <div class="min-h-screen flex" x-data="{ open: false }">
        <!-- Sidebar -->
        <aside 
            :class="open ? 'translate-x-0' : '-translate-x-full'" 
            class="fixed top-0 left-0 w-64 min-h-screen bg-white border-r z-50 transition-transform sm:translate-x-0 sm:w-72">
            <div class="p-4 border-b flex justify-between items-center">
                <div class="px-4 mx-auto py-3">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4CAF50&color=fff" alt="Admin"
                        class="w-16 h-16 rounded-full mx-auto mb-2">
                    <h3 class="text-center font-semibold text-gray-800">Administrator</h3>
                </div>
                <button @click="open = false" class="sm:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 text-gray-700 {{ request()->routeIs('dashboard') ? 'bg-green-50 border-r-4 border-green-500' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('paket') }}"
                class="flex items-center px-6 py-3 text-gray-600 {{ request()->routeIs('paket') ? 'bg-green-50 border-r-4 border-green-500' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Paket Laundry
            </a>

            <a href="{{ route('pelanggan') }}"
                class="flex items-center px-6 py-3 text-gray-600 {{ request()->routeIs('pelanggan') ? 'bg-green-50 border-r-4 border-green-500' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Pelanggan
            </a>

            <div x-data="{ open: false }">
                <div class="flex items-center px-6 py-3 text-gray-600 {{ request()->routeIs('stok-barang') || request()->routeIs('barang-masuk') || request()->routeIs('barang-keluar') ? 'bg-green-50 border-r-4 border-green-500' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors"
                    @click="open = !open">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Stok Barang
                    <svg class="w-5 h-5 ml-auto transition-transform transform" :class="{ 'rotate-180': open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div x-show="open" @click.away="open = false" class="ml-10 mt-2 space-y-2 pl-6">
                    <a href="{{ route('barang') }}"
                        class="block px-6 py-2 text-gray-600 {{ request()->routeIs('stok-barang') ? 'bg-green-50' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">Data
                        Barang</a>
                    <a href="{{ route('trx-barang-masuk') }}"
                        class="block px-6 py-2 text-gray-600 {{ request()->routeIs('barang-masuk') ? 'bg-green-50' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">Barang
                        Masuk</a>
                    <a href="{{ route('trx-barang-keluar') }}"
                        class="block px-6 py-2 text-gray-600 {{ request()->routeIs('barang-keluar') ? 'bg-green-50' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">Barang
                        Keluar</a>
                </div>
            </div>

            <a href="{{ route('transaksi') }}"
                class="flex items-center px-6 py-3 text-gray-600 {{ request()->routeIs('transaksi') ? 'bg-green-50 border-r-4 border-green-500' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Transaksi
            </a>

            <div x-data="{ open: false }">
                <a href="#"
                    class="flex items-center px-6 py-3 text-gray-600 {{ request()->routeIs('report') ? 'bg-green-50 border-r-4 border-green-500' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors"
                    @click="open = !open">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Report
                    <svg class="w-5 h-5 ml-auto transition-transform transform" :class="{ 'rotate-180': open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <div x-show="open" @click.away="open = false" class="ml-10 mt-2 space-y-2 pl-6">
                    <a href="#"
                        class="block px-6 py-2 text-gray-600 {{ request()->routeIs('report') ? 'bg-green-50' : 'hover:bg-green-50 hover:text-gray-700' }} transition-colors">Data
                        Report</a>
                </div>
            </div>
            </nav>
        </aside>
    


           <!-- Page Content -->
           <div class="flex-1 p-4">
            <!-- Header -->                 
                <button @click="open = true" class="sm:hidden p-2 bg-green-500 text-white rounded-md">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            <div class="flex flex-col items-end">
                <div class="flex items-center space-x-2">
                    <!-- Administrator Text -->
                    <span class="text-lg font-semibold text-gray-800">Administrator</span>

                    <!-- Logout Icon -->
                    <form method="POST" action="{{ route('logout') }}" class="relative">
                        @csrf
                        <button type="submit" class="flex items-center group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 text-gray-600 group-hover:text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                            </svg>
                            <!-- Tooltip -->
                            <span
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 scale-0 group-hover:scale-100 transition-all bg-gray-800 text-white text-xs font-medium py-1 px-2 rounded shadow-md">
                                Logout
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Slot -->
            <div class="mt-4 md:ml-72">
                {{ $slot }}
            </div>
        </div>
    </div>
    
    @stack('modals')
<!-- Development version -->
{{-- <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script> --}}

<!-- Production version -->
<script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
      </script>
    @livewireScripts
</body>

</html>
