<div>
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Pelanggan
        </x-slot>

        <x-slot name="description">
            Masukkan data pelanggan baru di bawah ini.
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
                    <select id="keterangan" wire:model="keterangan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-2">
                        <option value="">Pilih Keterangan</option>
                        <option value="Member">Member</option>
                        <option value="Non-Member">Non Member</option>
                    </select>
                    @error('keterangan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('pelanggan') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
