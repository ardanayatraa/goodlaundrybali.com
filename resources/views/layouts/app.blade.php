<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/css/tom-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    @livewireStyles
</head>

<body x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)" class="font-sans antialiased">
    <nav class="fixed top-0 z-10 w-full shadow-md bg-white border-b border-gray-200 ">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="#" class="flex ms-2">
                        <img src="/assets/img/logo.png" class="h-12 " alt="GoodLaundry Logo" />
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div class="flex items-center gap-7 space-x-2">

                            <!-- Profile Button -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" type="button"
                                    class="flex items-center text-sm bg-white rounded-full focus:ring-4 focus:ring-gray-300 ">
                                    <span class="sr-only">Open user menu</span>
                                    @php
                                        if (!function_exists('getInitials')) {
                                            function getInitials($name)
                                            {
                                                $names = explode(' ', $name);
                                                $initials = '';

                                                if (count($names) > 1) {
                                                    $initials = strtoupper($names[0][0] . $names[count($names) - 1][0]);
                                                } else {
                                                    $initials = strtoupper(substr($name, 0, 1) . substr($name, -1));
                                                }

                                                return $initials;
                                            }
                                        }

                                        $user = Auth::guard('admin')->user();
                                        $userName = $user->nama_admin;
                                        $userInitials = getInitials($userName);
                                        $userPhoto = $user->photo ?? null;
                                    @endphp


                                    @if ($userPhoto)
                                        <img class="w-12 h-12 rounded-full border-2 border-green-500 shadow-lg"
                                            src="{{ $userPhoto }}" alt="user photo">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-green-500 font-bold border-2 border-green-500 shadow-lg">
                                            {{ $userInitials }}
                                        </div>
                                    @endif
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open" @click.outside="open = false"
                                    class="absolute right-0 z-50 mt-2 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow "
                                    style="display: none;">
                                    <div class="px-4 py-3">
                                        <p class="text-sm text-gray-900">
                                            {{ auth()->guard('admin')->user()->nama_admin }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900 truncate ">
                                            {{ auth()->guard('admin')->user()->username }}
                                        </p>
                                    </div>
                                    <ul class="py-1">
                                        <li>
                                            <x-dropdown-link href="{{ route('dashboard') }}">
                                                {{ __('Dashboard') }}
                                            </x-dropdown-link>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf
                                                <x-dropdown-link href="{{ route('logout') }}"
                                                    @click.prevent="$root.submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 z-50 left-0 shadow-lg z-50 w-64 h-screen transition-transform transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full text-center px-3 pb-4 overflow-y-auto bg-white">
            <a href="#" class="flex justify-center items-center pt-8">
                <h2 class="text-lg font-semibold text-gray-900">
                    <img src="/assets/img/logo.png" class="h-32" alt="GoodLaundry Logo" />
                </h2>
            </a>
            <ul class="space-y-2 pt-8 font-medium">

                <!-- Dashboard -->
                <li class="relative px-6 py-3">
                    <span
                        class="absolute inset-y-0 left-0 w-1 {{ request()->routeIs('dashboard') ? 'bg-green-600' : '' }} rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-green-600 font-bold' : 'text-gray-800 hover:text-gray-800' }}"
                        href="{{ route('dashboard') }}">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>

                <!-- Dropdown Stok Barang -->
                @php
                    $stokActive =
                        request()->routeIs('barang') ||
                        request()->routeIs('trx-barang-masuk') ||
                        request()->routeIs('trx-barang-keluar');
                @endphp
                <li class="relative px-6 py-3">
                    <span
                        class="absolute inset-y-0 left-0 w-1 {{ $stokActive ? 'bg-green-600' : '' }} rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>

                    <!-- Tombol Dropdown -->
                    <button id="stokToggle"
                        class="flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
                                {{ $stokActive ? 'text-green-600 font-bold' : 'text-gray-800 hover:text-gray-800' }}">
                        <div class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                            </svg>

                            <span class="ml-4">Stok Barang</span>
                        </div>
                        <svg id="stokIcon" class="w-4 h-4 transition-transform transform" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 011.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul id="stokDropdown" class="pl-6 mt-4 hidden space-y-2 transition-all duration-300">
                        <li>
                            <a href="{{ route('barang') }}"
                                class="inline-flex items-center w-full text-sm font-medium px-3 py-2 rounded-lg
                                     {{ request()->routeIs('barang') ? 'bg-green-100 text-green-600' : 'text-gray-700 hover:text-gray-800 hover:bg-gray-100' }}">
                                - Data Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trx-barang-masuk') }}"
                                class="inline-flex items-center w-full text-sm font-medium px-3 py-2 rounded-lg
                                         {{ request()->routeIs('trx-barang-masuk') ? 'bg-green-100 text-green-600' : 'text-gray-700 hover:text-gray-800 hover:bg-gray-100' }}">
                                - Barang Masuk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trx-barang-keluar') }}"
                                class="inline-flex items-center w-full text-sm font-medium px-3 py-2 rounded-lg
                                           {{ request()->routeIs('trx-barang-keluar') ? 'bg-green-100 text-green-600' : 'text-gray-700 hover:text-gray-800 hover:bg-gray-100' }}">
                                - Barang Keluar
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- JavaScript untuk Toggle Dropdown -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let dropdown = document.getElementById("stokDropdown");
                        let toggleBtn = document.getElementById("stokToggle");
                        let icon = document.getElementById("stokIcon");
                        let stokActive = {{ $stokActive ? 'true' : 'false' }};

                        // Jika stokActive true, tampilkan dropdown saat halaman dimuat
                        if (stokActive) {
                            dropdown.classList.remove("hidden");
                            icon.classList.add("rotate-180");
                        }

                        // Toggle saat tombol diklik
                        toggleBtn.addEventListener("click", function() {
                            dropdown.classList.toggle("hidden");
                            icon.classList.toggle("rotate-180");
                        });
                    });
                </script>


                <!-- Menu Lainnya -->
                @php
                    $menus = [
                        'Paket' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                    </svg>
                                    ',
                        'Pelanggan' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                    ',
                        'Transaksi' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    ',
                        'Unit' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                    </svg>
                                    ',
                    ];
                @endphp

                @foreach ($menus as $menu => $icon)
                    @php
                        $routeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $menu));
                    @endphp
                    <li class="relative px-6 py-3">
                        <span
                            class="absolute inset-y-0 left-0 w-1 {{ request()->routeIs($routeName) ? 'bg-green-600' : '' }} rounded-tr-lg rounded-br-lg"
                            aria-hidden="true"></span>
                        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->routeIs($routeName) ? 'text-green-600 font-bold' : 'text-gray-800 hover:text-gray-800' }}"
                            href="{{ route($routeName) }}">
                            {!! $icon !!}
                            <span class="ml-4">{{ $menu }}</span>
                        </a>
                    </li>
                @endforeach
                <!-- Dropdown Report -->
                @php
                    $reportActive =
                        request()->routeIs('laporan-transaksi') || request()->routeIs('laporan-stok-barang');
                @endphp
                <li class="relative px-6 py-3">
                    <span
                        class="absolute inset-y-0 left-0 w-1 {{ $reportActive ? 'bg-green-600' : '' }} rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"></span>

                    <!-- Tombol Dropdown -->
                    <button id="reportToggle"
                        class="flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150
                {{ $reportActive ? 'text-green-600 font-bold' : 'text-gray-800 hover:text-gray-800' }}">
                        <div class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h18M3 9h18M3 15h18M3 21h18" />
                            </svg>
                            <span class="ml-4">Report</span>
                        </div>
                        <svg id="reportIcon" class="w-4 h-4 transition-transform transform" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.73a.75.75 0 011.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul id="reportDropdown" class="pl-6 mt-4 hidden space-y-2 transition-all duration-300">
                        <li>
                            <a href="{{ route('laporan-transaksi') }}"
                                class="inline-flex items-center w-full text-sm font-medium px-3 py-2 rounded-lg
                     {{ request()->routeIs('laporan-transaksi') ? 'bg-green-100 text-green-600' : 'text-gray-700 hover:text-gray-800 hover:bg-gray-100' }}">
                                - Laporan Transaksi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('laporan-stok-barang') }}"
                                class="inline-flex items-center w-full text-sm font-medium px-3 py-2 rounded-lg
                     {{ request()->routeIs('laporan-stok-barang') ? 'bg-green-100 text-green-600' : 'text-gray-700 hover:text-gray-800 hover:bg-gray-100' }}">
                                - Laporan Stok Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('laporan-pelanggan') }}"
                                class="inline-flex items-center w-full text-sm font-medium px-3 py-2 rounded-lg
                     {{ request()->routeIs('laporan-pelanggan') ? 'bg-green-100 text-green-600' : 'text-gray-700 hover:text-gray-800 hover:bg-gray-100' }}">
                                - Laporan Pelanggan
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- JavaScript untuk Toggle Dropdown -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let dropdown = document.getElementById("reportDropdown");
                        let toggleBtn = document.getElementById("reportToggle");
                        let icon = document.getElementById("reportIcon");
                        let reportActive = {{ $reportActive ? 'true' : 'false' }};

                        // Jika reportActive true, tampilkan dropdown saat halaman dimuat
                        if (reportActive) {
                            dropdown.classList.remove("hidden");
                            icon.classList.add("rotate-180");
                        }

                        // Toggle saat tombol diklik
                        toggleBtn.addEventListener("click", function() {
                            dropdown.classList.toggle("hidden");
                            icon.classList.toggle("rotate-180");
                        });
                    });
                </script>

            </ul>
        </div>
    </aside>



    <div class="p-4 mt-14 sm:ml-64">
        <div class="fixed bg-green-500 h-96 w-full top-0 left-0 z-[-10]">
            <!-- Your content here -->
        </div>


        <!-- Page Content -->
        <main>

            <div class="py-4">
                <div class="mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden p-8 border sm:rounded-lg">
                        <div id="loading-screen"
                            class="fixed inset-0 z-50 flex items-center justify-center w-screen h-screen bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg">
                            <div class="relative flex items-center justify-center">
                                <div
                                    class="absolute w-24 h-24 border-4 border-transparent border-t-green-600 border-l-green-600 rounded-full animate-spin">
                                </div>
                                <div
                                    class="absolute w-16 h-16 border-4 border-transparent border-t-green-400 border-l-green-400 rounded-full animate-spin-reverse">
                                </div>
                                <div class="absolute w-8 h-8 bg-green-600 rounded-full animate-pulse"></div>
                            </div>
                        </div>

                        <style>
                            @keyframes spin-reverse {
                                from {
                                    transform: rotate(0deg);
                                }

                                to {
                                    transform: rotate(-360deg);
                                }
                            }

                            .animate-spin-reverse {
                                animation: spin-reverse 1.5s linear infinite;
                            }
                        </style>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                setTimeout(() => {
                                    document.getElementById("loading-screen").style.display = "none";
                                }, 500); // Hilang setelah 2 detik
                            });
                        </script>

                        {{ $slot }}
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    @stack('modals')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("logo-sidebar");
            const toggleBtn = document.querySelector("[data-drawer-toggle]");
            const overlay = document.querySelector("[data-drawer-backdrop]");

            function closeSidebar() {
                sidebar.classList.add("-translate-x-full");
                overlay?.remove(); // Hapus overlay saat sidebar ditutup
            }

            toggleBtn.addEventListener("click", function() {
                if (!sidebar.classList.contains("-translate-x-full")) {
                    closeSidebar();
                }
            });

            document.addEventListener("click", function(event) {
                if (overlay && event.target === overlay) {
                    closeSidebar();
                }
            });
        });
    </script>


    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <x-toaster-hub />
</body>

</html>
