<div>
    <x-form-section submit="save">
        <x-slot name="title">Tambah Transaksi</x-slot>
        <x-slot name="description">Isi data di bawah ini.</x-slot>

        <x-slot name="form">
            <div class="space-y-6">

                {{-- 1) Cari Pelanggan --}}
                <div>
                    <x-label for="searchPelanggan" value="Cari Pelanggan" />
                    @if ($id_pelanggan)
                        <div class="mt-2 flex items-center gap-2 border rounded px-3 py-2 bg-white">
                            <span
                                class="flex-1">{{ $pelanggans->firstWhere('id_pelanggan', $id_pelanggan)?->nama_pelanggan }}</span>
                            <button type="button" wire:click="$set('id_pelanggan',null)"
                                class="text-red-500 font-bold">&times;</button>
                        </div>
                    @else
                        <x-input id="searchPelanggan" wire:model="searchPelanggan" placeholder="Ketik nama..."
                            class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm"
                            wire:focus="$set('focusedPelanggan',true)" wire:blur="$set('focusedPelanggan',false)" />
                        @if ($focusedPelanggan)
                            <ul class="mt-2 border rounded max-h-40 overflow-y-auto bg-white">
                                @forelse($pelanggans as $p)
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        wire:click="$set('id_pelanggan','{{ $p->id_pelanggan }}')">
                                        {{ $p->nama_pelanggan }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">Tidak ada hasil</li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_pelanggan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 2) Tanggal Transaksi --}}
                <div>
                    <x-label for="tanggal_transaksi" value="Tanggal Transaksi" />
                    <x-input id="tanggal_transaksi" type="date" wire:model="tanggal_transaksi"
                        class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                    @error('tanggal_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 3) Poin & Diskon --}}
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <x-label value="Jumlah Point" />
                        <x-input type="text" :value="$jumlah_point" disabled
                            class="w-full mt-2 bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                    </div>
                    <button type="button" wire:click="usePoints" class="mt-6 btn btn-primary">
                        Gunakan Poin
                    </button>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($pointsToRedeem)
                    <div class="text-gray-700 mb-4">
                        Poin dipakai: <strong>{{ $pointsToRedeem }}</strong>
                    </div>
                @endif

                {{-- 4) Opsi Pickup --}}
                <div class="mb-4">
                    <x-label value="Tanggal/Jam Ambil" />
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" wire:model="samePickup" value="1" class="form-radio" />
                        <span class="ml-2">Sama untuk semua paket</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="samePickup" value="0" class="form-radio" />
                        <span class="ml-2">Atur per paket</span>
                    </label>
                </div>

                {{-- 5) Global Pickup --}}
                @if ($samePickup)
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-label for="globalTanggalAmbil" value="Tanggal Ambil" />
                            <x-input id="globalTanggalAmbil" type="date" wire:model="globalTanggalAmbil"
                                class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                            @error('globalTanggalAmbil')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="globalJamAmbil" value="Jam Ambil" />
                            <x-input id="globalJamAmbil" type="time" wire:model="globalJamAmbil"
                                class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                            @error('globalJamAmbil')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- 6) Daftar Paket --}}
                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Daftar Paket</h3>
                    <button type="button" wire:click="addItem" class="mb-3 bg-green-500 text-white px-3 py-1 rounded">
                        + Tambah Paket
                    </button>

                    @foreach ($items as $idx => $row)
                        <div wire:key="item-{{ $idx }}"
                            class="{{ $samePickup ? 'grid grid-cols-5' : 'grid grid-cols-7' }} gap-4 mb-4 items-end">

                            {{-- Pilih Paket --}}
                            <div>
                                <x-label value="Paket #{{ $idx + 1 }}" />
                                <select wire:model.live="items.{{ $idx }}.id_paket"
                                    class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm">
                                    <option value="">-- pilih --</option>
                                    @foreach ($pakets as $p)
                                        <option value="{{ $p->id_paket }}">
                                            {{ $p->jenis_paket }} – Rp {{ number_format($p->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.$idx.id_paket")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div>
                                <x-label value="Harga" />
                                <x-input type="text" wire:model.live="items.{{ $idx }}.harga" disabled
                                    class="w-full mt-1 bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                            </div>

                            {{-- Jumlah --}}
                            <div>
                                <x-label value="Jumlah" />
                                <x-input type="number" min="1"
                                    wire:model.live="items.{{ $idx }}.jumlah"
                                    class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                                @error("items.$idx.jumlah")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Tanggal/Jam Ambil per-item --}}
                            @if (!$samePickup)
                                <div>
                                    <x-label value="Tgl Ambil" />
                                    <x-input type="date" wire:model.live="items.{{ $idx }}.tanggal_ambil"
                                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                                    @error("items.$idx.tanggal_ambil")
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <x-label value="Jam Ambil" />
                                    <x-input type="time" wire:model.live="items.{{ $idx }}.jam_ambil"
                                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                                    @error("items.$idx.jam_ambil")
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            {{-- Subtotal --}}
                            <div>
                                <x-label value="Subtotal" />
                                <x-input type="text" wire:model.live="items.{{ $idx }}.subtotal" disabled
                                    class="w-full mt-1 bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                            </div>

                            {{-- Hapus --}}
                            <div>
                                <button type="button" wire:click="removeItem({{ $idx }})"
                                    class="text-white bg-red-500 px-2 py-1 rounded">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- 7) Diskon & Total Harga --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <x-label value="Total Diskon" />
                        <x-input type="text" wire:model="total_diskon" disabled
                            class="w-full mt-2 bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                    </div>
                    <div>
                        <x-label value="Total Harga" />
                        <x-input type="text" wire:model="total_harga" disabled
                            class="w-full mt-2 bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm" />
                    </div>
                </div>

                {{-- 8) Pembayaran & Status --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <x-label value="Metode Pembayaran" />
                        <select wire:model="metode_pembayaran"
                            class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm">
                            <option value="">-- pilih metode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Qris">Qris</option>
                        </select>
                        @error('metode_pembayaran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Status Pembayaran" />
                        <select wire:model="status_pembayaran"
                            class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm">
                            <option value="">-- pilih status --</option>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                        @error('status_pembayaran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- 9) Status Transaksi & Keterangan --}}
                <div class="mb-6">
                    <x-label value="Status Transaksi" />
                    <select wire:model="status_transaksi"
                        class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm">
                        <option value="">-- pilih status --</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Siap Ambil">Siap Ambil</option>
                        <option value="Terambil">Terambil</option>
                    </select>
                    @error('status_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <x-label value="Keterangan" />
                    <textarea wire:model="keterangan" rows="3"
                        class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xs shadow-sm px-2 py-1"></textarea>
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">
                Simpan
            </x-button>
            <a href="{{ route('transaksi') }}"
                class="ml-2 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Batal
            </a>
        </x-slot>
    </x-form-section>
</div>
