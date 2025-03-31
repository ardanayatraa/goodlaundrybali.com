<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Laporan Transaksi</h2>
        <x-button wire:click="downloadPDF">
            Download PDF
        </x-button>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-4">
        <div>
            <x-label for="filterType" value="Jenis Laporan" />
            <select id="filterType" wire:model="filterType" class="w-full p-2 border rounded-lg">
                <option value="harian">Harian</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
            </select>
        </div>
        <div>
            <x-label for="startDate" value="Tanggal" />
            <x-input type="date" id="startDate" wire:model="startDate" class="w-full" />
        </div>
        @if ($filterType !== 'harian')
            <div>
                <x-label for="endDate" value="Sampai Tanggal" />
                <x-input type="date" id="endDate" wire:model="endDate" class="w-full" />
            </div>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border rounded-lg overflow-hidden shadow-md">
            <thead class="bg-gray-200 text-gray-700">
                <tr class="text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Pelanggan</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2 text-right">Total Harga</th>
                    <th class="px-4 py-2 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @php $no = 1; @endphp
                @foreach ($groupedTransaksi as $idPelanggan => $group)
                    <tr class="bg-gray-100">
                        <td class="px-4 py-2 font-bold">{{ $no++ }}</td>
                        <td class="px-4 py-2 font-bold">{{ $group['pelanggan'] }}</td>
                        <td colspan="3" class="px-4 py-2 font-bold text-right">
                            Subtotal: Rp {{ number_format($group['subtotal'], 0, ',', '.') }}
                        </td>
                    </tr>
                    @foreach ($group['transactions'] as $item)
                        <tr>
                            <td class="px-4 py-2"></td>
                            <td class="px-4 py-2">{{ $item->pelanggan->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->tanggal_transaksi }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $item->status_transaksi == 'Selesai' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $item->status_transaksi }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                <tr class="bg-gray-200 font-bold">
                    <td colspan="3" class="px-4 py-2 text-right">Grand Total:</td>
                    <td colspan="2" class="px-4 py-2 text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
