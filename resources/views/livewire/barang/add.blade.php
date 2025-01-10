<div>
    <!-- Button to Open Modal -->
    <button wire:click="$set('showModal', true)"
        class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        Tambah Barang
    </button>

    <!-- Jetstream Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Barang
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <label for="nama_barang" class="block text-gray-700 font-semibold">Nama Barang</label>
                <input type="text" id="nama_barang" wire:model="nama_barang"
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('nama_barang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700 font-semibold">Harga</label>
                <div class="flex items-center">
                    <span class="mr-2 text-gray-500">Rp</span>
                    <input type="number" step="0.01" id="harga" wire:model="harga"
                        class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>
                @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
