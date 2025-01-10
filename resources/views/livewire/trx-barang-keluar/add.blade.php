<div>
    <!-- Button to Open Modal -->
    <button wire:click="$set('showModal', true)"
        class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        Tambah Transaksi Barang Keluar
    </button>

    <!-- Jetstream Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Transaksi Barang Keluar
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
                <label for="tanggal_keluar" class="block text-gray-700 font-semibold">Tanggal Keluar</label>
                <input type="date" id="tanggal_keluar" wire:model="tanggal_keluar"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('tanggal_keluar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="nama_admin" class="block text-gray-700 font-semibold">Nama Admin</label>
                <input type="text" id="nama_admin" wire:model="nama_admin"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('nama_admin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
