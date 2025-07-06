<div>
    {{-- FILTER & CONTROL --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex flex-wrap items-center gap-4">
            {{-- Tipe Filter --}}
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Filter:</label>
                <select wire:model.live="filterType"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                    <option value="rentang">Rentang Tanggal</option>
                </select>
            </div>

            {{-- Input Tanggal (untuk harian) --}}
            @if ($filterType === 'harian')
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Tanggal:</label>
                    <input type="date" wire:model.live="filterDate"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            @endif

            {{-- Input Tanggal (untuk mingguan) --}}
            @if ($filterType === 'mingguan')
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Minggu:</label>
                    <input type="date" wire:model.live="filterDate"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <small class="text-gray-500 text-xs">Pilih tanggal dalam minggu</small>
                </div>
            @endif

            {{-- Input Bulan (untuk bulanan) --}}
            @if ($filterType === 'bulanan')
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Bulan:</label>
                    <input type="month" wire:model.live="filterMonth"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            @endif

            {{-- Input Tahun (untuk tahunan) --}}
            @if ($filterType === 'tahunan')
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Tahun:</label>
                    <select wire:model.live="filterYear"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            @endif

            {{-- Input Rentang Tanggal --}}
            @if ($filterType === 'rentang')
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Dari:</label>
                    <input type="date" wire:model.live="startDate"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Sampai:</label>
                    <input type="date" wire:model.live="endDate"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            @endif

            {{-- Pencarian Nama Barang --}}
            <div class="flex-1 min-w-[250px]">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari nama barang..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>

            {{-- Tombol Cetak PDF --}}
            <div>
                <button wire:click="exportPdf"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Cetak PDF
                </button>
            </div>
        </div>

        {{-- Filter Summary --}}
        <div class="mt-3 pt-3 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Filter aktif:</span>
                    <span class="ml-1 text-blue-600">
                        @if ($filterType === 'harian')
                            {{ \Carbon\Carbon::parse($filterDate)->format('d M Y') }}
                        @elseif($filterType === 'mingguan')
                            Minggu {{ \Carbon\Carbon::parse($filterDate)->startOfWeek()->format('d M') }} -
                            {{ \Carbon\Carbon::parse($filterDate)->endOfWeek()->format('d M Y') }}
                        @elseif($filterType === 'bulanan')
                            {{ \Carbon\Carbon::parse($filterMonth)->format('F Y') }}
                        @elseif($filterType === 'tahunan')
                            Tahun {{ $filterYear }}
                        @elseif($filterType === 'rentang')
                            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        @endif
                    </span>
                </div>
                @if ($search)
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Pencarian:</span>
                        <span class="ml-1 text-orange-600">"{{ $search }}"</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Barang
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stok Awal
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Masuk
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Keluar
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stok Akhir
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $brg)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $brg->nama_barang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                <span class="font-mono">{{ number_format($brg->stok_awal ?? 0) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                @if (($brg->total_masuk ?? 0) > 0)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        +{{ number_format($brg->total_masuk) }}
                                    </span>
                                @else
                                    <span class="font-mono text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                @if (($brg->total_keluar ?? 0) > 0)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        -{{ number_format($brg->total_keluar) }}
                                    </span>
                                @else
                                    <span class="font-mono text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                <span
                                    class="font-mono font-semibold {{ ($brg->stok_akhir ?? 0) > 0 ? 'text-green-600' : (($brg->stok_akhir ?? 0) < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                    {{ number_format($brg->stok_akhir ?? 0) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="text-sm font-medium">Tidak ada data barang</p>
                                    <p class="text-xs text-gray-400 mt-1">untuk periode yang dipilih</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Summary --}}
        @if ($barangs->count() > 0)
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm">
                    <div class="text-gray-600">
                        <span class="font-medium">Total: {{ $barangs->count() }} barang</span>
                    </div>
                    <div class="flex items-center space-x-6 text-gray-600">
                        <div>
                            <span class="font-medium">Total Masuk:</span>
                            <span
                                class="ml-1 text-green-600 font-mono">+{{ number_format($barangs->sum('total_masuk')) }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Total Keluar:</span>
                            <span
                                class="ml-1 text-red-600 font-mono">-{{ number_format($barangs->sum('total_keluar')) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
