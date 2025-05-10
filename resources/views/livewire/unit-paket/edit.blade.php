<div>
    <x-form-section submit="update">
        <x-slot name="title">
            Edit Unit Paket
        </x-slot>

        <x-slot name="description">
            Perbarui data unit paket di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <!-- Input Nama Unit -->
                <div>
                    <x-label for="nama_unit" value="Nama Unit" />
                    <x-input id="nama_unit" type="text" wire:model="nama_unit" class="w-full mt-2" />
                    @error('nama_unit')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Input Keterangan -->
                <div>
                    <x-label for="keterangan" value="Keterangan" />
                    <textarea id="keterangan" wire:model="keterangan" class="w-full mt-2 border-gray-300 rounded-lg"></textarea>
                    @error('keterangan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-yellow-500 text-white">Update</x-button>
            <a href="{{ route('unit-paket') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
