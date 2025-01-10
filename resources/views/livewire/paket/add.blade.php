<div>
    <!-- Tombol Untuk Membuka Modal -->
    <button wire:click="$set('showModal', true)" class=" border mb-8 text-green-800 px-4 py-2 rounded ">
        Tambah Paket
    </button>

    <!-- Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Paket
        </x-slot>

        <x-slot name="content">
            @if (session()->has('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="jenis_paket" class="block text-sm font-medium text-gray-700">Jenis Paket</label>
                <input type="text" id="jenis_paket" wire:model="jenis_paket" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Masukkan jenis paket">
                @error('jenis_paket') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="text" id="harga" wire:model="harga" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Masukkan harga">
                @error('harga') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="waktu_pengerjaan" class="block text-sm font-medium text-gray-700">Waktu Pengerjaan (hari)</label>
                <input type="number" id="waktu_pengerjaan" wire:model="waktu_pengerjaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Masukkan waktu pengerjaan">
                @error('waktu_pengerjaan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$set('showModal', false)" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Batal
            </button>
            <button wire:click="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
