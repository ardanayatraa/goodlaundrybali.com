<div>
    <x-form-section submit="update">
        <x-slot name="title">
            Edit Barang
        </x-slot>

        <x-slot name="description">
            Perbarui data barang di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div>
                    <x-label for="nama_barang" value="Nama Barang" />
                    <x-input id="nama_barang" type="text" wire:model="nama_barang" class="w-full mt-2" />
                    @error('nama_barang')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="harga" value="Harga" />
                    <x-input id="harga" type="text" wire:model="harga" class="w-full mt-2" />
                    @error('harga')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="stok" value="Stok" />
                    <x-input id="stok" type="text" wire:model="stok" class="w-full mt-2" />
                    @error('stok')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="searchUnit" value="Cari Unit" />
                    @if ($id_unit)
                        <div class="mt-2 flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <span class="text-sm text-gray-700 flex-1">
                                {{ $units->firstWhere('id_unit', $id_unit)?->nama_unit }}
                            </span>
                            <button type="button" wire:click="$set('id_unit', null)"
                                class="text-red-500 hover:underline font-bold">
                                &times;
                            </button>
                        </div>
                    @else
                        <x-input id="searchUnit" type="text" wire:model="searchUnit" class="w-full mt-2"
                            placeholder="Ketik nama unit..." wire:focus="$set('focusedUnit', true)"
                            wire:blur="$set('focusedUnit', false)" />
                        @if ($focusedUnit)
                            <ul class="mt-2 border border-gray-300 rounded-lg max-h-40 overflow-y-auto">
                                @forelse ($units as $unit)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="$set('id_unit', '{{ $unit->id_unit }}')">
                                        {{ $unit->nama_unit }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">
                                        Tidak ada hasil untuk "{{ $searchUnit }}"
                                    </li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_unit')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white">Simpan</x-button>
            <a href="{{ route('barang') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
