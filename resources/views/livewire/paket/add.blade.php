<div>
    <!-- Using x-form-section for a clean section around the form -->
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Paket
        </x-slot>

        <x-slot name="description">
            Isi data berikut untuk menambah paket baru.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label for="jenis_paket" value="Jenis Paket" />
                    <x-input id="jenis_paket" type="text" wire:model="jenis_paket" class="mt-2 w-full" />
                    @error('jenis_paket') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <x-label for="harga" value="Harga" />
                    <x-input id="harga" type="number" wire:model="harga" class="mt-2 w-full" />
                    @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <x-label for="unit" value="Unit" />
                    <x-input id="unit" type="text" wire:model="unit" class="mt-2 w-full" />
                    @error('unit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <x-label for="waktu_pengerjaan" value="Waktu Pengerjaan" />
                    <x-input id="waktu_pengerjaan" type="text" wire:model="waktu_pengerjaan" class="mt-2 w-full" />
                    @error('waktu_pengerjaan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('paket') }}" 
            class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
             <i data-lucide="x-circle" class="w-5 h-5"></i>
             <span>Batal</span>
         </a>
        </x-slot>
    </x-form-section>
</div>
