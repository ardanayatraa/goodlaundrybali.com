<div>
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Detail Transaksi
        </x-slot>

        <x-slot name="description">
            Isi data berikut untuk menambahkan detail transaksi baru.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label for="id_transaksi" value="ID Transaksi" />
                    <x-input id="id_transaksi" type="number" wire:model="id_transaksi" class="mt-2 w-full" />
                    @error('id_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="id_paket" value="ID Paket" />
                    <x-input id="id_paket" type="number" wire:model="id_paket" class="mt-2 w-full" />
                    @error('id_paket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="jumlah" value="Jumlah" />
                    <x-input id="jumlah" type="number" wire:model="jumlah" class="mt-2 w-full" />
                    @error('jumlah')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="subtotal" value="Subtotal" />
                    <x-input id="subtotal" type="number" wire:model="subtotal" class="mt-2 w-full" />
                    @error('subtotal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('detail-transaksi') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
