<div>
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Unit Paket
        </x-slot>

        <x-slot name="description">
            Silakan isi detail unit paket di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div>
                    <x-label for="id_paket" value="Paket" />
                    <select id="id_paket" wire:model="id_paket" class="w-full mt-2 border-gray-300 rounded-lg">
                        <option value="">Pilih Paket</option>
                        @foreach ($pakets as $paket)
                            <option value="{{ $paket->id_paket }}">{{ $paket->nama_paket }}</option>
                        @endforeach
                    </select>
                    @error('id_paket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="id_unit" value="Unit" />
                    <select id="id_unit" wire:model="id_unit" class="w-full mt-2 border-gray-300 rounded-lg">
                        <option value="">Pilih Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id_unit }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                    @error('id_unit')
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
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('unit-paket') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
