<div>
    <x-form-section submit="save">
        <x-slot name="title">Tambah Barang Masuk</x-slot>
        <x-slot name="description">Isi detail di bawah ini.</x-slot>
        <x-slot name="form">
            <div class="space-y-6">

                {{-- Admin --}}
                <div>
                    <x-label for="searchAdmin" value="Cari Admin" />
                    @if ($id_admin)
                        <div class="mt-2 flex items-center gap-2 border-gray-300 border rounded-lg px-3 py-2 bg-white">
                            <span
                                class="flex-1 text-sm">{{ $admins->firstWhere('id_admin', $id_admin)?->nama_admin }}</span>
                            <button type="button" wire:click="$set('id_admin',null)"
                                class="text-red-500 font-bold hover:underline">&times;</button>
                        </div>
                    @else
                        <x-input id="searchAdmin" type="text" wire:model="searchAdmin"
                            class="w-full mt-2 border-gray-300 rounded-md shadow-sm" placeholder="Ketik nama admin..."
                            wire:focus="$set('focusedAdmin',true)" wire:blur="$set('focusedAdmin',false)" />
                        @if ($focusedAdmin)
                            <ul class="mt-2 border-gray-300 border rounded-lg max-h-40 overflow-y-auto bg-white z-10">
                                @forelse($admins as $admin)
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        wire:click="$set('id_admin','{{ $admin->id_admin }}')">
                                        {{ $admin->nama_admin }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">Tidak ada hasil</li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_admin')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal Masuk --}}
                <div>
                    <x-label for="tanggal_masuk" value="Tanggal Masuk" />
                    <x-input id="tanggal_masuk" type="date" wire:model="tanggal_masuk"
                        value="{{ now()->format('Y-m-d') }}" class="w-full mt-2 border-gray-300 rounded-md shadow-sm" />
                    @error('tanggal_masuk')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Daftar Barang Masuk --}}
                <div>
                    <h3 class="font-semibold mb-2">Daftar Barang</h3>
                    <button type="button" wire:click="addItem"
                        class="mb-3 bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                        + Tambah Baris
                    </button>

                    @foreach ($items as $i => $item)
                        <div wire:key="item-{{ $i }}" class="flex items-center space-x-4 mb-4">
                            {{-- Barang (flexible, shrinks) --}}
                            <div class="flex-1 min-w-0">
                                <x-label value="Barang #{{ $i + 1 }}" class="text-gray-700" />
                                <select wire:model="items.{{ $i }}.id_barang"
                                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 truncate">
                                    <option value="">— pilih —</option>
                                    @foreach ($barangs as $b)
                                        <option value="{{ $b->id_barang }}">
                                            {{ $b->nama_barang }} – {{ $b->unit?->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.$i.id_barang")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jumlah --}}
                            <div class="flex-none w-20">
                                <x-label value="Jumlah" class="text-gray-700" />
                                <x-input type="number" min="1" wire:model="items.{{ $i }}.jumlah"
                                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm" />
                                @error("items.$i.jumlah")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="flex-none w-28">
                                <x-label value="Harga" class="text-gray-700" />
                                <x-input type="text" wire:model="items.{{ $i }}.harga" disabled
                                    class="w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm" />
                            </div>

                            {{-- Subtotal --}}
                            <div class="flex-none w-28">
                                <x-label value="Subtotal" class="text-gray-700" />
                                <x-input type="text" wire:model="items.{{ $i }}.subtotal" disabled
                                    class="w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm" />
                            </div>

                            {{-- Hapus --}}
                            <div class="flex-none">
                                <button type="button" wire:click="removeItem({{ $i }})"
                                    class="w-8 h-8 bg-red-500 mt-5 hover:bg-red-600 text-white rounded-full flex items-center justify-center">&times;
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Simpan Semua
            </x-button>
            <a href="{{ route('trx-barang-masuk') }}"
                class="ml-2 inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Batal
            </a>
        </x-slot>
    </x-form-section>
</div>
