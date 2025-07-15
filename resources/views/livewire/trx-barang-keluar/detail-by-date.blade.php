<div class="w-full mx-auto p-6 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between bg-red-600 text-white p-4 rounded-lg shadow">
        <h2 class="text-2xl font-bold">Laporan Barang Keluar</h2>
        <div class="space-x-2">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Cari tanggal..."
                class="px-3 py-1 text-black rounded">
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer"
                        wire:click="sortBy('tanggal')">
                        Tanggal
                        @if ($sortField === 'tanggal')
                            @if ($sortAsc)
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Jumlah Transaksi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer"
                        wire:click="sortBy('total_keluar')">
                        Total Barang Keluar
                        @if ($sortField === 'total_keluar')
                            @if ($sortAsc)
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer"
                        wire:click="sortBy('total_harga')">
                        Total Harga
                        @if ($sortField === 'total_harga')
                            @if ($sortAsc)
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Barang
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($data as $row)
                    <tr class="{{ $loop->even ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($row->tanggal)->isoFormat('D MMMM YYYY') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->jumlah_transaksi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->total_keluar }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                            Rp {{ number_format($row->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate" title="{{ $row->barang_list }}">
                            {{ Str::limit($row->barang_list, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="viewByDate('{{ $row->tanggal }}')"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($data->isEmpty())
        <p class="text-center text-gray-500">Tidak ada data transaksi.</p>
    @endif

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>
