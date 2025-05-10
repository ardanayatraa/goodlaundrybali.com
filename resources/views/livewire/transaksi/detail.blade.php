<div class="w-full mx-auto p-6 space-y-6">
    <!-- Header -->
    <div
        class="flex items-center justify-between bg-gradient-to-r from-green-500 to-green-500 text-white p-5 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold flex items-center space-x-2">
            <i class="fas fa-receipt text-2xl"></i>
            <span>Detail Transaksi #{{ $transaksi->id_transaksi }}</span>
        </h2>
        <div class="inline-flex items-center space-x-2">
            <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}" target="_blank"
                class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition inline-flex items-center">
                <i class="fas fa-print mr-2"></i><span>Cetak</span>
            </a>
            <a href="{{ route('transaksi') }}"
                class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i><span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Transaksi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-4 flex items-center space-x-4">
            <i class="fas fa-user text-green-600 text-3xl"></i>
            <div>
                <p class="text-xs text-gray-500 uppercase">Pelanggan</p>
                <p class="text-lg font-semibold">{{ $transaksi->pelanggan->nama_pelanggan }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 flex items-center space-x-4">
            <i class="fas fa-box-open text-indigo-600 text-3xl"></i>
            <div>
                <p class="text-xs text-gray-500 uppercase">Nama Paket</p>
                <p class="text-lg font-semibold">{{ $transaksi->paket->jenis_paket }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 flex items-center space-x-4">
            <i class="fas fa-calendar-alt text-green-600 text-3xl"></i>
            <div>
                <p class="text-xs text-gray-500 uppercase">Tgl. Transaksi</p>
                <p class="text-lg font-semibold">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 flex items-center space-x-4">
            <i class="fas fa-wallet text-yellow-600 text-3xl"></i>
            <div>
                <p class="text-xs text-gray-500 uppercase">Total Harga</p>
                <p class="text-lg font-semibold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Paket -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-4">Detail Paket</h3>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <li><strong>Jenis Paket:</strong> {{ $transaksi->paket->jenis_paket }}</li>
            <li><strong>Harga Paket:</strong> Rp {{ number_format($transaksi->paket->harga, 0, ',', '.') }}</li>
            <li><strong>Unit Paket:</strong> {{ $transaksi->paket->unitPaket->nama_unit ?? '-' }}</li>
            <li><strong>Waktu Pengerjaan:</strong> {{ $transaksi->paket->waktu_pengerjaan }} Jam</li>
            <li><strong>Unit Barang:</strong> {{ $transaksi->paket->unit }}</li>
        </ul>
    </div>

    <!-- Tabel Detail Transaksi -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Ambil</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Ambil</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Diskon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transaksi->detailTransaksi as $idx => $detail)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($detail->tanggal_ambil)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jam_ambil }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->jumlah }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp
                            {{ number_format($detail->total_diskon, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada detail transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
