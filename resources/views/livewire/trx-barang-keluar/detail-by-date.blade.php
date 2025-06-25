<div class="w-full mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between bg-red-600 text-white p-4 rounded-lg shadow">
        <h2 class="text-2xl font-bold">
            Detail Barang Keluar
            <span class="font-light">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM YYYY') }}</span>
        </h2>
        <div class="space-x-2">
            <a href="{{ route('trx-barang-keluar.print-by-date', ['tanggal' => $tanggal]) }}" target="_blank"
                class="bg-white text-red-600 px-3 py-1 rounded hover:bg-red-50">
                <i class="fas fa-print mr-1"></i> Cetak
            </a>
            <a href="{{ route('trx-barang-keluar') }}" class="bg-white text-red-600 px-3 py-1 rounded hover:bg-red-50">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        ID Transaksi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Nama Barang
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Unit
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Admin
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Jumlah
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Harga Satuan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Total Harga
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($records as $row)
                    <tr class="{{ $loop->even ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->id_trx_brgkeluar }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->barang->nama_barang }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->barang->unit->nama_unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->admin->nama_admin }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $row->jumlah_brgkeluar }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            Rp {{ number_format($row->barang->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                            Rp {{ number_format($row->barang->harga * $row->jumlah_brgkeluar, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($records->isEmpty())
        <p class="text-center text-gray-500">Tidak ada data pada tanggal ini.</p>
    @endif

</div>
