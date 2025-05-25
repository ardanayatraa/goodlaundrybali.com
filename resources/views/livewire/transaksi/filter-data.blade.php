<div class="p-6 bg-white rounded-xl shadow-lg">
    {{-- 1) FORM FILTER (GET) --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-6 flex flex-wrap gap-4 items-end">
        {{-- TANGGAL --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal', '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        {{-- STATUS PEMBAYARAN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Status Bayar</label>
            <select name="status-pembayaran"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua</option>
                <option value="Belum Bayar" {{ request('status-pembayaran') == 'Belum Bayar' ? 'selected' : '' }}>Belum
                    Bayar
                </option>
                <option value="Lunas" {{ request('status-pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>

        {{-- STATUS TRANSAKSI --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Status Transaksi</label>
            <select name="status-transaksi"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua</option>
                <option value="Diproses" {{ request('status-transaksi') == 'Diproses' ? 'selected' : '' }}>Diproses
                </option>
                <option value="Siap Ambil" {{ request('status-transaksi') == 'Siap Ambil' ? 'selected' : '' }}>Siap
                    Ambil
                </option>
                <option value="Terambil" {{ request('status-transaksi') == 'Terambil' ? 'selected' : '' }}>Terambil
                </option>
            </select>
        </div>

        {{-- BUTTONS --}}
        <div class="flex space-x-2">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow">
                Filter
            </button>
            <a href="{{ url()->current() }}"
                class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md shadow">
                Clear
            </a>
        </div>
    </form>

    {{-- 2) DATATABLE --}}
    @php
        $fT = request('tanggal', '');
        $fP = request('status-pembayaran', '');
        $fS = request('status-transaksi', '');
    @endphp

    @livewire('table.transaksi-table', [
        'filterTanggal' => $fT,
        'filterPembayaran' => $fP,
        'filterTransaksi' => $fS,
    ])
</div>
