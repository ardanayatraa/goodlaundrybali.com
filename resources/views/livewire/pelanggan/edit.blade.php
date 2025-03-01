<div>
    <x-form-section submit="update">
        <x-slot name="title">
            Edit Pelanggan
        </x-slot>

        <x-slot name="description">
            Update data pelanggan di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label for="nama_pelanggan" value="Nama Pelanggan" />
                    <x-input id="nama_pelanggan" type="text" wire:model="nama_pelanggan" class="mt-2 w-full" />
                    @error('nama_pelanggan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="no_telp" value="No Telp" />
                    <x-input id="no_telp" type="text" wire:model="no_telp" class="mt-2 w-full" />
                    @error('no_telp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="alamat" value="Alamat" />
                    <x-input id="alamat" type="text" wire:model="alamat" class="mt-2 w-full" />
                    @error('alamat')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="keterangan" value="Keterangan" />
                    <x-input id="keterangan" type="text" wire:model="keterangan" class="mt-2 w-full" />
                    @error('keterangan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-yellow-500 text-white">Update</x-button>
            <a href="{{ route('pelanggan') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
