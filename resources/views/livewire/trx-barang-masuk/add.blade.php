<div>
    <!-- Button to Open Modal -->
    <button wire:click="$set('showModal', true)"
        class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        Tambah Transaksi Barang Masuk
    </button>

    <!-- Jetstream Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Transaksi Barang Masuk
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <label for="id_barang" class="block text-gray-700 font-semibold">Barang</label>
                <select id="id_barang" wire:model="id_barang"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">Pilih Barang</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id_barang }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
                @error('id_barang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal_masuk" class="block text-gray-700 font-semibold">Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" wire:model="tanggal_masuk"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('tanggal_masuk') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="nama_admin" class="block text-gray-700 font-semibold">Nama Admin</label>
                <input type="text" id="nama_admin" wire:model="nama_admin"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('nama_admin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="total_harga" class="block text-gray-700 font-semibold">Total Harga</label>
                <div class="flex items-center">
                    <span class="mr-2 text-gray-500">Rp</span>
                    <input type="number" step="0.01" id="total_harga" wire:model="total_harga"
                        class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>
                @error('total_harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
