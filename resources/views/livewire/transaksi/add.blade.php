<div>
    <!-- Button to Open Modal -->
    <button wire:click="$set('showModal', true)"
        class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        Tambah Transaksi
    </button>

    <!-- Jetstream Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Transaksi
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <label for="nama_pelanggan" class="block text-gray-700 font-semibold">Nama Pelanggan</label>
                <input type="text" id="nama_pelanggan" wire:model="nama_pelanggan"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('nama_pelanggan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal_transaksi" class="block text-gray-700 font-semibold">Tanggal Transaksi</label>
                <input type="date" id="tanggal_transaksi" wire:model="tanggal_transaksi"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('tanggal_transaksi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="total_harga" class="block text-gray-700 font-semibold">Total Harga (Rp)</label>
                <input type="number" id="total_harga" wire:model="total_harga" step="0.01"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('total_harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="metode_pembayaran" class="block text-gray-700 font-semibold">Metode Pembayaran</label>
                <input type="text" id="metode_pembayaran" wire:model="metode_pembayaran"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('metode_pembayaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="status_pembayaran" class="block text-gray-700 font-semibold">Status Pembayaran</label>
                <input type="text" id="status_pembayaran" wire:model="status_pembayaran"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('status_pembayaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="status_transaksi" class="block text-gray-700 font-semibold">Status Transaksi</label>
                <input type="text" id="status_transaksi" wire:model="status_transaksi"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('status_transaksi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="jumlah_point" class="block text-gray-700 font-semibold">Jumlah Point</label>
                <input type="number" id="jumlah_point" wire:model="jumlah_point"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('jumlah_point') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="status_bonus" class="block text-gray-700 font-semibold">Status Bonus</label>
                <input type="text" id="status_bonus" wire:model="status_bonus"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('status_bonus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                Batal
            </x-secondary-button>

            <x-button class="ml-2" wire:click="submit" wire:loading.attr="disabled">
                Simpan
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
