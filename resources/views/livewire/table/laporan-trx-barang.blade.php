<div>
    {{-- FILTER & CONTROL --}}
    <div class="flex flex-wrap items-center justify-between mb-4 space-x-4">
        {{-- Tipe Filter --}}
        <div>
            <label class="font-medium mr-2">Filter:</label>
            <select wire:model="filterType" class="px-3 py-2 border rounded-md focus:outline-none focus:ring">
                <option value="harian">Harian</option>
                <option value="mingguan">Mingguan</option>
            </select>
        </div>

        {{-- Tanggal / Minggu --}}
        <div>
            <label class="font-medium mr-2">
                {{ $filterType === 'harian' ? 'Tanggal' : 'Minggu' }}:
            </label>
            <input type="date" wire:model="filterDate"
                class="px-3 py-2 border rounded-md focus:outline-none focus:ring">
        </div>

        {{-- Pencarian Nama Barang --}}
        <div class="flex-1">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Cari nama barang..."
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring">
        </div>

        {{-- Tombol Cetak PDF --}}
        <div>
            <button wire:click="exportPdf" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Cetak PDF
            </button>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Nama Barang</th>
                    <th class="px-4 py-2 text-right">Stok Awal</th>
                    <th class="px-4 py-2 text-right">Total Masuk</th>
                    <th class="px-4 py-2 text-right">Total Keluar</th>
                    <th class="px-4 py-2 text-right">Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $brg)
                    <tr>
                        <td class="border px-4 py-2">{{ $brg->nama_barang }}</td>
                        <td class="border px-4 py-2 text-right">{{ $brg->stok_awal }}</td>
                        <td class="border px-4 py-2 text-right">{{ $brg->total_masuk }}</td>
                        <td class="border px-4 py-2 text-right">{{ $brg->total_keluar }}</td>
                        <td class="border px-4 py-2 text-right">{{ $brg->stok_akhir }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-center">— Tidak ada data —</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
