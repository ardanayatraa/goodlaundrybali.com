@props(['id', 'status', 'total'])

<div class="payment-component relative" data-id="{{ $id }}" data-total="{{ $total }}">
    @if ($status === 'Belum Bayar')
        <button type="button" class="btn-pay bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
            Bayar
        </button>
    @else
        <span class="inline-block bg-green-100 text-green-800 px-2 py-1 text-xs rounded">
            ✅ Lunas
        </span>
    @endif

    {{-- Modal Bayar (default hidden) --}}
    <div class="payment-modal-overlay fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg w-72">
            <h3 class="font-semibold mb-3 text-center">Pembayaran #{{ $id }}</h3>

            {{-- Total Tagihan --}}
            <div class="mb-2">
                <span class="text-xs text-gray-600">Total Tagihan:</span>
                <div class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</div>
            </div>

            {{-- Input Jumlah Bayar --}}
            <div class="mb-2">
                <label class="block text-xs font-medium">Jumlah Bayar:</label>
                <input type="number" min="0" step="0.01"
                    class="jumlah-bayar w-full border rounded px-2 py-1 text-sm">
            </div>

            {{-- Tampilkan Kembalian --}}
            <div class="mb-4">
                <label class="block text-xs font-medium">Kembalian:</label>
                <div class="font-bold text-right">
                    Rp <span class="kembalian">0</span>
                </div>
            </div>

            {{-- Aksi Simpan / Batal --}}
            <div class="flex justify-end space-x-2">
                <button type="button"
                    class="save-payment-btn bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                    Simpan
                </button>
                <button type="button"
                    class="cancel-payment-btn bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-1 rounded text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Buka modal saat tombol Bayar diklik
        document.body.addEventListener('click', e => {
            if (!e.target.classList.contains('btn-pay')) return;

            const wrapper = e.target.closest('.payment-component');
            const overlay = wrapper.querySelector('.payment-modal-overlay');
            const total = parseFloat(wrapper.dataset.total);
            const inp = wrapper.querySelector('.jumlah-bayar');
            const back = wrapper.querySelector('.kembalian');

            // reset & tampilkan
            overlay.classList.remove('hidden');
            inp.value = total.toFixed(2);
            back.textContent = '0';
        });

        // Hitung kembalian saat input berubah
        document.body.addEventListener('input', e => {
            if (!e.target.classList.contains('jumlah-bayar')) return;

            const wrapper = e.target.closest('.payment-component');
            const total = parseFloat(wrapper.dataset.total);
            const bayar = parseFloat(e.target.value) || 0;
            const back = wrapper.querySelector('.kembalian');

            back.textContent = Math.max(0, bayar - total).toLocaleString('id-ID');
        });

        // Simpan pembayaran
        document.body.addEventListener('click', e => {
            if (!e.target.classList.contains('save-payment-btn')) return;

            const wrapper = e.target.closest('.payment-component');
            const id = wrapper.dataset.id;
            const total = parseFloat(wrapper.dataset.total);
            const overlay = wrapper.querySelector('.payment-modal-overlay');
            const inp = wrapper.querySelector('.jumlah-bayar');
            const back = wrapper.querySelector('.kembalian');

            const bayar = parseFloat(inp.value) || 0;
            const kemb = Math.max(0, bayar - total);

            // Kirim ke Livewire
            Livewire.emit('savePaymentFromTable', id, bayar, kemb);

            // Update UI
            overlay.classList.add('hidden');
            wrapper.querySelector('.btn-pay').remove();
            wrapper.insertAdjacentHTML('beforeend',
                '<span class="inline-block bg-green-100 text-green-800 px-2 py-1 text-xs rounded">✅ Lunas</span>'
            );
        });

        // Batal pembayaran
        document.body.addEventListener('click', e => {
            if (!e.target.classList.contains('cancel-payment-btn')) return;

            const overlay = e.target.closest('.payment-modal-overlay');
            overlay.classList.add('hidden');
        });
    });
</script>
