<div class="w-full mx-auto p-6 space-y-6">
    <div class="flex items-center justify-between bg-red-600 text-white p-4 rounded-lg shadow">
        <h2 class="text-2xl font-bold">Detail Barang Keluar #{{ $keluar->id_trx_brgkeluar }}</h2>
        <div class="space-x-2">
            <a href="{{ route('trx-barang-keluar.cetak', $keluar->id_trx_brgkeluar) }}" target="_blank"
                class="bg-white text-red-600 px-3 py-1 rounded hover:bg-red-50">
                <i class="fas fa-print mr-1"></i> Cetak
            </a>
            <a href="{{ route('trx-barang-keluar') }}" class="bg-white text-red-600 px-3 py-1 rounded hover:bg-red-50">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
            <tbody class="divide-y divide-gray-200">
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Nama Barang</th>
                    <td class="px-6 py-4">{{ $keluar->barang->nama_barang }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Tanggal Keluar</th>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($keluar->tanggal_keluar)->format('d M Y') }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Admin</th>
                    <td class="px-6 py-4">{{ $keluar->admin->nama_admin }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Unit Satuan</th>
                    <td class="px-6 py-4">{{ $keluar->unit }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left font-medium text-gray-700">Jumlah Keluar</th>
                    <td class="px-6 py-4">{{ $keluar->jumlah_brgkeluar }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
