<x-app-layout>
{{ Breadcrumbs::render('dashboard') }} 
      <!-- Main Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
                <!-- Pelanggan Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.1s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-400">Pelanggan</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">1,482</h3>
                    <p class="text-sm text-green-500 mt-2">+12% from last month</p>
                </div>

                <!-- Paket Laundry Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-400">Active Packages</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">64</h3>
                    <p class="text-sm text-blue-500 mt-2">8 new packages</p>
                </div>

                <!-- Transaksi Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover animate-fade-in" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-lg bg-purple-100">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-400">Transactions</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Rp 8.2M</h3>
                    <p class="text-sm text-purple-500 mt-2">+23% this week</p>
                </div>
            </div>

        
            <!-- Business Info -->
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-lg bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Good Laundry Kedonganan</h3>
                        <p class="text-sm text-gray-600">Jl. Raya Uluwatu, No. Kelan, Kedonganan, Kec. Kuta, Kab. Badung, Bali 80363</p>
                    </div>
                </div>
            </div>
</x-app-layout>
