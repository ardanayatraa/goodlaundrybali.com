<div>
    <!-- Using x-form-section for a clean section around the form -->
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Paket
        </x-slot>

        <x-slot name="description">
            Isi data berikut untuk menambah paket baru.
        </x-slot>

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <x-slot name="form">
            <div class="space-y-6">


                <div>
                    <x-label for="searchUnitPaket" value="Cari Unit Paket" />
                    @if ($id_unit_paket)
                        <div class="mt-2 flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <span class="text-sm text-gray-700 flex-1">
                                {{ $unitPakets->firstWhere('id_unit_paket', $id_unit_paket)?->nama_unit }}
                            </span>
                            <button type="button" wire:click="$set('id_unit_paket', null)"
                                class="text-red-500 hover:underline font-bold">
                                &times;
                            </button>
                        </div>
                    @else
                        <x-input id="searchUnitPaket" type="text" wire:model="searchUnitPaket" class="w-full mt-2"
                            placeholder="Ketik nama unit paket..." wire:focus="$set('focusedUnitPaket', true)"
                            wire:blur="$set('focusedUnitPaket', false)" />
                        @if ($focusedUnitPaket)
                            <ul class="mt-2 border border-gray-300 rounded-lg max-h-40 overflow-y-auto">
                                @forelse ($unitPakets as $unitPaket)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="$set('id_unit_paket', {{ $unitPaket->id_unit_paket }})">
                                        {{ $unitPaket->nama_unit }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">Tidak ada hasil untuk "{{ $searchUnitPaket }}"
                                    </li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_unit_paket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="jenis_paket" value="Jenis Paket" />
                    <x-input id="jenis_paket" type="text" wire:model="jenis_paket" class="mt-2 w-full" />
                    @error('jenis_paket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="harga" value="Harga" />
                    <x-input id="harga" type="number" wire:model="harga" class="mt-2 w-full" />
                    @error('harga')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="unit" value="Unit" />
                    <x-input id="unit" type="text" wire:model="unit" class="mt-2 w-full" />
                    @error('unit')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="waktu_pengerjaan" value="Waktu Pengerjaan" />
                    <x-input id="waktu_pengerjaan" type="text" wire:model="waktu_pengerjaan" class="mt-2 w-full" />
                    @error('waktu_pengerjaan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
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
