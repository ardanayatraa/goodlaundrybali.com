{{-- resources/views/livewire/transaksi/detail.blade.php --}}
<div class="p-6 bg-white rounded-xl shadow-lg">
    {{-- Logo --}}
    <div class="flex justify-center mb-4">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Laundry" class="w-20">
    </div>

    {{-- Title --}}
    <h2 class="text-center text-2xl font-bold mb-2">GOOD LAUNDRY KEDONGANAN</h2>
    <p class="text-center text-base mb-4">
        Jl. Raya Uluwatu, No. Kelan, Kedonganan,<br>
        Kec. Kuta, Kab. Badung, Bali 80363
    </p>
    <div class="border-t border-gray-300 mb-6"></div>

    {{-- Header Info --}}
    <table class="w-full mb-6 text-base">
        <tbody>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Id Transaksi</td>
                <td class="py-1">: {{ $transaksi->id_transaksi }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Tanggal Transaksi</td>
                <td class="py-1">
                    :
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->translatedFormat('l, d F Y') }}
                </td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Nama Pelanggan</td>
                <td class="py-1">: {{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Alamat</td>
                <td class="py-1">: {{ $transaksi->pelanggan->alamat ?? '-' }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">No Telp</td>
                <td class="py-1">: {{ $transaksi->pelanggan->no_telp ?? '-' }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Metode Pembayaran</td>
                <td class="py-1">: {{ $transaksi->metode_pembayaran }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Status Pembayaran</td>
                <td class="py-1">: {{ ucfirst($transaksi->status_pembayaran) }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Point Saat Ini</td>
                <td class="py-1">: {{ $transaksi->pelanggan->point ?? '0' }}</td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Keterangan (Qris)</td>
                <td class="py-1">: {{ $transaksi->keterangan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Items --}}
    <table class="w-full mb-6 text-base border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1 text-center">Jenis Paket</th>
                <th class="border px-2 py-1 text-center">Tanggal Ambil</th>
                <th class="border px-2 py-1 text-center">Unit</th>
                <th class="border px-2 py-1 text-center">Jumlah</th>
                <th class="border px-2 py-1 text-center">Harga</th>
                <th class="border px-2 py-1 text-center">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $idx => $detail)
                <tr class="{{ $idx % 2 ? '' : 'bg-gray-50' }}">
                    <td class="border px-2 py-1 text-center">{{ $detail->paket->jenis_paket }}</td>
                    <td class="border px-2 py-1 text-center">{{ $detail->tanggal_ambil }}</td>
                    <td class="border px-2 py-1 text-center">
                        {{ $detail->paket->unit->nama_unit ?? $detail->paket->unit }}
                    </td>
                    <td class="border px-2 py-1 text-center">{{ $detail->jumlah }}</td>
                    <td class="border px-2 py-1 text-right">
                        Rp {{ number_format($detail->paket->harga, 0, ',', '.') }}
                    </td>
                    <td class="border px-2 py-1 text-right">
                        Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer Totals --}}
    <table class="w-full mb-6 text-base">
        <tbody>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Diskon</td>
                <td class="py-1">:
                    Rp {{ number_format($transaksi->detailTransaksi->sum('total_diskon'), 0, ',', '.') }}
                </td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Subtotal</td>
                <td class="py-1">:
                    <strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                </td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Jumlah Bayar</td>
                <td class="py-1">:
                    Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="odd:bg-gray-50">
                <td class="py-1 font-medium">Kembalian</td>
                <td class="py-1">:
                    Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Buttons --}}
    <div class="mt-4 flex justify-end space-x-2">
        <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}" target="_blank"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <i class="fas fa-print mr-2"></i> Cetak
        </a>
        <a href="{{ route('transaksi') }}"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="text-center font-semibold mt-6">-----TERIMAKASIH-----</div>
</div>
