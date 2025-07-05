<div>
    <x-form-section submit="save">
        <x-slot name="title">Tambah Transaksi</x-slot>
        <x-slot name="description">Isi data transaksi dan pembayaran.</x-slot>

        <x-slot name="form">
            <div class="space-y-6">

                {{-- 1) Cari Pelanggan --}}
                <div>
                    <x-label for="searchPelanggan" value="Cari Pelanggan" />
                    @if ($id_pelanggan)
                        <div class="mt-2 flex items-center gap-2 border rounded px-3 py-2 bg-white">
                            <span class="flex-1">
                                {{ $pelanggans->firstWhere('id_pelanggan', $id_pelanggan)?->nama_pelanggan }}
                            </span>
                            <button wire:click="$set('id_pelanggan',null)" class="text-red-500">&times;</button>
                        </div>
                    @else
                        <x-input id="searchPelanggan" wire:model.live="searchPelanggan" placeholder="Ketik nama..."
                            wire:focus="$set('focusedPelanggan',true)" wire:blur="$set('focusedPelanggan',false)"
                            class="w-full mt-2" />
                        @if ($focusedPelanggan)
                            <ul class="mt-2 border rounded max-h-40 overflow-y-auto bg-white">
                                @forelse($pelanggans as $p)
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        wire:click="$set('id_pelanggan','{{ $p->id_pelanggan }}')">
                                        {{ $p->id_pelanggan }} – {{ $p->nama_pelanggan }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">Tidak ada hasil</li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_pelanggan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 2) Tanggal Transaksi --}}
                <div>
                    <x-label for="tanggal_transaksi" value="Tanggal Transaksi" />
                    <x-input id="tanggal_transaksi" type="date" wire:model.live="tanggal_transaksi"
                        class="w-full mt-2" />
                    @error('tanggal_transaksi')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 3) Poin & Diskon --}}
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <x-label value="Jumlah Point" />
                        <x-input type="text" :value="$jumlah_point" disabled class="w-full mt-2 bg-gray-100" />
                    </div>
                    <button wire:click="usePoints" type="button" class="bg-blue-500 text-white px-4 py-2 rounded mt-6">
                        Gunakan Poin
                    </button>
                </div>
                @if (session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="text-red-600">{{ session('error') }}</div>
                @endif
                @if ($pointsToRedeem)
                    <div class="text-gray-700">Poin dipakai: <strong>{{ $pointsToRedeem }}</strong> → Diskon Rp
                        {{ number_format($total_diskon, 0, ',', '.') }}</div>
                @endif

                {{-- 4) Opsi Pickup --}}
                <div>
                    <x-label value="Tanggal/Jam Ambil" />
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" wire:model.live="samePickup" value="1" class="form-radio" />
                        <span class="ml-2">Sama untuk semua</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model.live="samePickup" value="0" class="form-radio" />
                        <span class="ml-2">Atur per paket</span>
                    </label>
                </div>

                {{-- 5) Global Pickup --}}
                @if ($samePickup)
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label value="Tgl Ambil" />
                            <x-input type="date" wire:model.live="globalTanggalAmbil" class="w-full mt-2" />
                            @error('globalTanggalAmbil')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-label value="Jam Ambil" />
                            <x-input type="time" wire:model.live="globalJamAmbil" class="w-full mt-2" />
                            @error('globalJamAmbil')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- 6) Daftar Paket --}}
                <div>
                    <h3 class="font-semibold mb-2">Daftar Paket</h3>
                    <button wire:click="addItem" type="button" class="bg-green-500 text-white px-3 py-1 rounded mb-2">
                        + Tambah Paket
                    </button>
                    @foreach ($items as $idx => $row)
                        <div wire:key="item-{{ $idx }}"
                            class="{{ $samePickup ? 'grid grid-cols-5' : 'grid grid-cols-7' }} gap-4 mb-4">
                            <div>
                                <select wire:model.live="items.{{ $idx }}.id_paket"
                                    class="w-full mt-2 border-gray-300 rounded">
                                    <option value="">-- pilih --</option>
                                    @foreach ($pakets as $p)
                                        <option value="{{ $p->id_paket }}">{{ $p->jenis_paket }} – Rp
                                            {{ number_format($p->harga, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                @error("items.$idx.id_paket")
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input type="text" wire:model.live="items.{{ $idx }}.harga" disabled
                                    class="w-full bg-gray-100" />
                            </div>
                            <div>
                                <x-input type="number" min="1"
                                    wire:model.live="items.{{ $idx }}.jumlah" class="w-full" />
                                @error("items.$idx.jumlah")
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            @unless ($samePickup)
                                <div>
                                    <x-input type="date" wire:model.live="items.{{ $idx }}.tanggal_ambil"
                                        class="w-full" />
                                    @error("items.$idx.tanggal_ambil")
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <x-input type="time" wire:model.live="items.{{ $idx }}.jam_ambil"
                                        class="w-full" />
                                    @error("items.$idx.jam_ambil")
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endunless
                            <div>
                                <x-input type="text" wire:model.live="items.{{ $idx }}.subtotal" disabled
                                    class="w-full bg-gray-100" />
                            </div>
                            <div>
                                <button wire:click="removeItem({{ $idx }})" type="button"
                                    class="bg-red-500 text-white px-2 py-1 rounded">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- 7) Diskon & Total Harga --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label value="Total Diskon" />
                        <x-input type="text" :value="'Rp ' . number_format($total_diskon, 0, ',', '.')" disabled class="w-full bg-gray-100" />
                    </div>
                    <div>
                        <x-label value="Total Harga" />
                        <x-input type="text" :value="'Rp ' . number_format($total_harga, 0, ',', '.')" disabled class="w-full bg-gray-100" />
                    </div>
                </div>

                {{-- 8) Pembayaran & Status --}}
                <div class="grid grid-cols-3 gap-4 mt-6">
                    <div>
                        <x-label value="Metode Pembayaran" />
                        <select wire:model.live="metode_pembayaran" class="w-full mt-1 border-gray-300 rounded">
                            <option value="">-- pilih metode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Qris">Qris</option>
                        </select>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Status Pembayaran" />
                        <select wire:model.live="status_pembayaran" class="w-full mt-1 border-gray-300 rounded">
                            <option value="">-- pilih status --</option>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                        @error('status_pembayaran')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Jumlah Bayar" />
                        <x-input type="number" min="0" step="0.01" wire:model.live="jumlah_bayar"
                            class="w-full" />
                        @error('jumlah_bayar')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-3 mt-2">
                        <p><strong>Kembalian:</strong> Rp {{ number_format($kembalian, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- 9) Status Transaksi & Keterangan --}}
                <div class="grid grid-cols-1 gap-4 mt-4">
                    <div>
                        <x-label value="Status Transaksi" />
                        <select wire:model.live="status_transaksi" class="w-full mt-1 border-gray-300 rounded">
                            <option value="Diproses">Diproses</option>
                            <option value="Siap Ambil">Siap Ambil</option>
                            <option value="Terambil">Terambil</option>
                        </select>
                        @error('status_transaksi')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Keterangan" />
                        <textarea wire:model.live="keterangan" rows="3" class="w-full border-gray-300 rounded px-2 py-1"></textarea>
                    </div>
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button class="bg-blue-600 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('transaksi') }}" class="ml-2 bg-red-600 text-white px-4 py-2 rounded">Batal</a>
        </x-slot>
    </x-form-section>
</div>
