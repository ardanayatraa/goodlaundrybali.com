<div>
    <x-form-section submit="update">
        <x-slot name="title">
            Edit Point
        </x-slot>

        <x-slot name="description">
            Update data point pelanggan di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label for="id_pelanggan" value="Pelanggan" />
                    <x-input id="id_pelanggan" type="number" wire:model="id_pelanggan" class="mt-2 w-full" />
                    @error('id_pelanggan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="tanggal" value="Tanggal" />
                    <x-input id="tanggal" type="date" wire:model="tanggal" class="mt-2 w-full" />
                    @error('tanggal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="jumlah_point" value="Jumlah Point" />
                    <x-input id="jumlah_point" type="number" wire:model="jumlah_point" class="mt-2 w-full" />
                    @error('jumlah_point')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-yellow-500 text-white">Update</x-button>
            <a href="{{ route('point') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
