<div class="space-y-4">

    <!-- Filters & PDF Button -->
    <div class="flex flex-wrap items-center gap-3">
        <input wire:model.debounce.500ms="search" type="text" placeholder="Cari nama barang…"
            class="px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring" />
        <input wire:model.live="start_date" type="date"
            class="px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring" />
        <span class="font-semibold">–</span>
        <input wire:model.live="end_date" type="date"
            class="px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring" />

        <select wire:model="perPage" class="px-3 py-2 border rounded shadow-sm">
            @foreach ([5, 10, 25, 50] as $pp)
                <option value="{{ $pp }}">{{ $pp }} / halaman</option>
            @endforeach
        </select>

        <button wire:click="generatePdf"
            class="ml-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow">
            Cetak PDF
        </button>
    </div>

    <!-- Tabel Ringkasan Stok -->
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full">
            <thead class="bg-gray-100 text-xs font-medium text-gray-600 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Barang</th>
                    <th class="px-4 py-2 text-right">Stok Awal</th>
                    <th class="px-4 py-2 text-right">Masuk</th>
                    <th class="px-4 py-2 text-right">Keluar</th>
                    <th class="px-4 py-2 text-right">Stok Akhir</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($stockSummary as $idx => $s)
                    <tr class="{{ $idx % 2 ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="px-4 py-2">{{ $barangs->firstItem() + $idx }}</td>
                        <td class="px-4 py-2">{{ $s->barang->nama_barang }}</td>
                        <td class="px-4 py-2 text-right">{{ $s->stok_awal }}</td>
                        <td class="px-4 py-2 text-right">{{ $s->masuk }}</td>
                        <td class="px-4 py-2 text-right">{{ $s->keluar }}</td>
                        <td class="px-4 py-2 text-right">{{ $s->stok_akhir }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                            Tidak ada data.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            @if ($stockSummary->isNotEmpty())
                <tfoot class="bg-gray-100 font-semibold text-gray-700">
                    <tr>
                        <td colspan="2" class="px-4 py-2 text-right">TOTAL:</td>
                        <td class="px-4 py-2 text-right">{{ $stockSummary->sum('stok_awal') }}</td>
                        <td class="px-4 py-2 text-right">{{ $stockSummary->sum('masuk') }}</td>
                        <td class="px-4 py-2 text-right">{{ $stockSummary->sum('keluar') }}</td>
                        <td class="px-4 py-2 text-right">{{ $stockSummary->sum('stok_akhir') }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $barangs->links() }}
    </div>
</div>
