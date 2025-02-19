<div>
    <!-- Directly display the form using x-form-section -->
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Barang
        </x-slot>

        <x-slot name="description">
            Masukkan data barang baru di bawah ini.
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
                    <x-input id="harga" type="text" wire:model="harga" class="w-full mt-2" />
                    @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <x-label for="stok" value="Stok" />
                    <x-input id="stok" type="text" wire:model="stok" class="w-full mt-2" />
                    @error('stok') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white">Simpan</x-button>
            <a href="{{ route('barang') }}" 
            class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
             <i data-lucide="x-circle" class="w-5 h-5"></i>
             <span>Batal</span>
        </x-slot>
    </x-form-section>
</div>
