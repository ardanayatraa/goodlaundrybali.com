<div>
    <x-form-section submit="update">
        <x-slot name="title">
            Edit Barang Keluar
        </x-slot>

        <x-slot name="description">
            Perbarui data barang keluar di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div>
                    <x-label for="id_barang" value="ID Barang" />
                    <x-input id="id_barang" type="number" wire:model="id_barang" class="w-full mt-2" />
                    @error('id_barang')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="jumlah" value="Jumlah" />
                    <x-input id="jumlah" type="number" wire:model="jumlah" class="w-full mt-2" />
                    @error('jumlah')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tanggal_keluar" value="Tanggal Keluar" />
                    <x-input id="tanggal_keluar" type="date" wire:model="tanggal_keluar" class="w-full mt-2" />
                    @error('tanggal_keluar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-yellow-500 text-white">Update</x-button>
            <a href="{{ route('trx-barang-keluar') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
