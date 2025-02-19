<div>
    <!-- Directly display the edit form using x-form-section -->
    <x-form-section submit="update">
        <x-slot name="title">
            Edit Barang
        </x-slot>

        <x-slot name="description">
            Perbarui informasi barang di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label for="nama_barang" value="Nama Barang" />
                    <x-input id="nama_barang" type="text" wire:model="nama_barang" class="w-full mt-2" />
                    @error('nama_barang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <x-label for="harga" value="Harga" />
                    <x-input id="harga" type="number" wire:model="harga" class="w-full mt-2" />
                    @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <x-label for="stok" value="Stok" />
                    <x-input id="stok" type="number" wire:model="stok" class="w-full mt-2" />
                    @error('stok') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-yellow-500 text-white">Update</x-button>
            <a href="{{ route('barang') }}" 
            class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
             <i data-lucide="x-circle" class="w-5 h-5"></i>
             <span>Batal</span>
        </x-slot>
    </x-form-section>
</div>
