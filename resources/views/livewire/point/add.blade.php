<div>
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Point
        </x-slot>

        <x-slot name="description">
            Masukkan data point pelanggan di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div>
                    <x-label for="searchPelanggan" value="Cari Pelanggan" />
                    @if ($id_pelanggan)
                        <div class="mt-2 flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <span class="text-sm text-gray-700 flex-1">
                                {{ $pelanggans->firstWhere('id_pelanggan', $id_pelanggan)?->nama_pelanggan }}
                            </span>
                            <button type="button" wire:click="$set('id_pelanggan', null)"
                                class="text-red-500 hover:underline font-bold">
                                &times;
                            </button>
                        </div>
                    @else
                        <x-input id="searchPelanggan" type="text" wire:model="searchPelanggan" class="w-full mt-2"
                            placeholder="Ketik nama pelanggan..." wire:focus="$set('focusedPelanggan', true)"
                            wire:blur="$set('focusedPelanggan', false)" />
                        @if ($focusedPelanggan)
                            <ul class="mt-2 border border-gray-300 rounded-lg max-h-40 overflow-y-auto">
                                @forelse ($pelanggans as $pelanggan)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="$set('id_pelanggan', '{{ $pelanggan->id_pelanggan }}')">
                                        {{ $pelanggan->nama_pelanggan }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">
                                        Tidak ada hasil untuk "{{ $searchPelanggan }}"
                                    </li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
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
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('point') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
