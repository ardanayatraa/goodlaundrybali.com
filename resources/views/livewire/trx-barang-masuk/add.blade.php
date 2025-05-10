<div>
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Barang Masuk
        </x-slot>

        <x-slot name="description">
            Silakan isi detail barang masuk di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <div>
                    <x-label for="searchBarang" value="Cari Barang" />
                    @if ($id_barang)
                        <div class="mt-2 flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <span class="text-sm text-gray-700 flex-1">
                                {{ $barangs->firstWhere('id_barang', $id_barang)?->nama_barang }}
                            </span>
                            <button type="button" wire:click="$set('id_barang', null)"
                                class="text-red-500 hover:underline font-bold">
                                &times;
                            </button>
                        </div>
                    @else
                        <x-input id="searchBarang" type="text" wire:model="searchBarang" class="w-full mt-2"
                            placeholder="Ketik nama barang..." wire:focus="$set('focusedBarang', true)"
                            wire:blur="$set('focusedBarang', false)" />
                        @if ($focusedBarang)
                            <ul class="mt-2 border border-gray-300 rounded-lg max-h-40 overflow-y-auto">
                                @forelse ($barangs as $barang)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="$set('id_barang', '{{ $barang->id_barang }}')">
                                        {{ $barang->nama_barang }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">
                                        Tidak ada hasil untuk "{{ $searchBarang }}"
                                    </li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_barang')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="searchAdmin" value="Cari Admin" />
                    @if ($id_admin)
                        <div class="mt-2 flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <span class="text-sm text-gray-700 flex-1">
                                {{ $admins->firstWhere('id_admin', $id_admin)?->nama_admin }}
                            </span>
                            <button type="button" wire:click="$set('id_admin', null)"
                                class="text-red-500 hover:underline font-bold">
                                &times;
                            </button>
                        </div>
                    @else
                        <x-input id="searchAdmin" type="text" wire:model="searchAdmin" class="w-full mt-2"
                            placeholder="Ketik nama admin..." wire:focus="$set('focusedAdmin', true)"
                            wire:blur="$set('focusedAdmin', false)" />
                        @if ($focusedAdmin)
                            <ul class="mt-2 border border-gray-300 rounded-lg max-h-40 overflow-y-auto">
                                @forelse ($admins as $admin)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="$set('id_admin', '{{ $admin->id_admin }}')">
                                        {{ $admin->nama_admin }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">
                                        Tidak ada hasil untuk "{{ $searchAdmin }}"
                                    </li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_admin')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <x-label for="jumlah" value="Jumlah" />
                    <x-input id="jumlah" type="text" wire:model="jumlah" class="w-full mt-2" />
                    @error('jumlah')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tanggal_masuk" value="Tanggal Masuk" />
                    <x-input id="tanggal_masuk" type="date" wire:model="tanggal_masuk" class="w-full mt-2" />
                    @error('tanggal_masuk')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="harga" value="Harga" />
                    <x-input id="harga" type="text" wire:model="harga" class="w-full mt-2" disabled />
                </div>

                <div>
                    <x-label for="total_harga" value="Total Harga" />
                    <x-input id="total_harga" type="text" wire:model="total_harga" class="w-full mt-2" disabled />
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('trx-barang-masuk') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            $('.select2').select2();

            $('.select2').on('change', function(e) {
                var data = $(this).val();
                @this.set($(this).attr('id'), data);
            });
        });
    </script>
@endpush
