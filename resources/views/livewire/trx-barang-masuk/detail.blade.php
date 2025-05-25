<div class="w-full mx-auto p-6 space-y-6">
    <div class="flex items-center justify-between bg-green-600 text-white p-4 rounded-lg shadow">
        <h2 class="text-2xl font-bold">Detail Barang Masuk #{{ $masuk->id_trx_brgmasuk }}</h2>
        <div class="space-x-2">
            <a href="{{ route('trx-barang-masuk.cetak', $masuk->id_trx_brgmasuk) }}" target="_blank"
                class="bg-white text-green-600 px-3 py-1 rounded hover:bg-green-50">
                <i class="fas fa-print mr-1"></i> Cetak
            </a>
            <a href="{{ route('trx-barang-masuk') }}" class="bg-white text-green-600 px-3 py-1 rounded hover:bg-green-50">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
            <tbody class="divide-y divide-gray-200">
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Nama Barang</th>
                    <td class="px-6 py-4">{{ $masuk->barang->nama_barang }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Unit</th>
                    <td class="px-6 py-4">{{ $masuk->barang->unit->nama_unit }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Tanggal Masuk</th>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($masuk->tanggal_masuk)->format('d M Y') }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Admin</th>
                    <td class="px-6 py-4">{{ $masuk->admin->nama_admin }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Jumlah Masuk</th>
                    <td class="px-6 py-4">{{ $masuk->jumlah_brgmasuk }} {{ $masuk->unit }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Harga Satuan</th>
                    <td class="px-6 py-4">Rp {{ number_format($masuk->harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Total Harga</th>
                    <td class="px-6 py-4">Rp {{ number_format($masuk->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
