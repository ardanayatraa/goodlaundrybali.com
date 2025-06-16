<div class="space-y-4">

    {{-- Controls --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-2">
            <span>Show</span>
            <select wire:model="perPage"
                class="block w-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option>5</option>
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
            <span>entries</span>
        </div>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12.9 14.32a8 8 0 111.414-1.414l5.387 5.387-1.414 1.414-5.387-5.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <input wire:model.debounce.300ms="search" type="text" placeholder="Search Tanggal…"
                class="block w-full sm:w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow-sm rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-white">
                <tr>
                    <th wire:click="sortBy('tanggal')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer select-none">
                        Tanggal
                        @if ($sortField == 'tanggal')
                            @if ($sortAsc)
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Barang
                    </th>
                    <th wire:click="sortBy('total_harga')"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer select-none">
                        Total Harga
                        @if ($sortField == 'total_harga')
                            @if ($sortAsc)
                                ▲
                            @else
                                ▼
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($data as $row)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                        {{-- Tanggal --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('Y-m-d') }}
                        </td>

                        {{-- Barang (badge) --}}
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">
                            @foreach (explode(',', $row->barang_list) as $nama)
                                <span
                                    class="inline-block px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full mr-1 mb-1">
                                    {{ $nama }}
                                </span>
                            @endforeach
                        </td>

                        {{-- Total Harga --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            Rp {{ number_format($row->total_harga, 0, ',', '.') }}
                        </td>

                        {{-- Action --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <button wire:click="viewByDate('{{ $row->tanggal }}')"
                                class="text-indigo-600 hover:text-indigo-900">
                                Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Results {{ $data->firstItem() }} – {{ $data->lastItem() }} of {{ $data->total() }}
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
</div>
