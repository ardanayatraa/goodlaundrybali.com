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
                            <button type="button" wire:click="$set('id_pelanggan',null)"
                                class="text-red-500">&times;</button>
                        </div>
                    @else
                        <x-input id="searchPelanggan" wire:model.live="searchPelanggan" placeholder="Ketik nama..."
                            wire:focus="$set('focusedPelanggan',true)" wire:blur="$set('focusedPelanggan',false)"
                            class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded shadow-sm" />
                        @if ($focusedPelanggan)
                            <ul class="mt-2 border rounded max-h-40 overflow-y-auto bg-white">
                                @forelse($pelanggans as $p)
                                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                        wire:click="$set('id_pelanggan','{{ $p->id_pelanggan }}')">
                                        {{ $p->id_pelanggan }} - {{ $p->nama_pelanggan }}
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
                    <x-input id="tanggal_transaksi" type="date" wire:model.live="tanggal_transaksi"
                        class="w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded shadow-sm" />
                    @error('tanggal_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- 3) Poin --}}
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <x-label value="Jumlah Point" />
                        <x-input type="text" :value="$jumlah_point" disabled
                            class="w-full mt-2 bg-gray-100 border-gray-300 rounded shadow-sm" />
                    </div>
                    <button type="button" wire:click="usePoints" class="btn btn-primary mt-6">
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
                        Poin dipakai: <strong>{{ $pointsToRedeem }}</strong> → Diskon
                        Rp {{ number_format($total_diskon, 0, ',', '.') }}
                    </div>
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

                {{-- 5) Pickup Global --}}
                @if ($samePickup)
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label value="Tgl Ambil" />
                            <x-input type="date" wire:model.live="globalTanggalAmbil"
                                class="w-full mt-2 border-gray-300 rounded shadow-sm" />
                            @error('globalTanggalAmbil')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label value="Jam Ambil" />
                            <x-input type="time" wire:model.live="globalJamAmbil"
                                class="w-full mt-2 border-gray-300 rounded shadow-sm" />
                            @error('globalJamAmbil')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- 6) Daftar Paket --}}
                <div>
                    <h3 class="font-semibold mb-2">Daftar Paket</h3>
                    <button type="button" wire:click="addItem" class="bg-green-500 text-white px-3 py-1 rounded mb-2">
                        + Tambah Paket
                    </button>
                    @foreach ($items as $idx => $row)
                        <div wire:key="item-{{ $idx }}"
                            class="{{ $samePickup ? 'grid grid-cols-5' : 'grid grid-cols-7' }} gap-4 mb-4">

                            {{-- Pilih Paket --}}
                            <div>
                                <select wire:model.live="items.{{ $idx }}.id_paket"
                                    class="w-full mt-2 border-gray-300 rounded shadow-sm">
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
                                <x-input type="text" wire:model.live="items.{{ $idx }}.harga" disabled
                                    class="w-full bg-gray-100 rounded shadow-sm" />
                            </div>

                            {{-- Jumlah --}}
                            <div>
                                <x-input type="number" min="1"
                                    wire:model.live="items.{{ $idx }}.jumlah"
                                    class="w-full rounded shadow-sm" />
                                @error("items.$idx.jumlah")
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Tgl/Jam Ambil per-item --}}
                            @unless ($samePickup)
                                <div>
                                    <x-input type="date" wire:model.live="items.{{ $idx }}.tanggal_ambil"
                                        class="w-full rounded shadow-sm" />
                                    @error("items.$idx.tanggal_ambil")
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <x-input type="time" wire:model.live="items.{{ $idx }}.jam_ambil"
                                        class="w-full rounded shadow-sm" />
                                    @error("items.$idx.jam_ambil")
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endunless

                            {{-- Subtotal --}}
                            <div>
                                <x-input type="text" wire:model.live="items.{{ $idx }}.subtotal" disabled
                                    class="w-full bg-gray-100 rounded shadow-sm" />
                            </div>

                            {{-- Hapus --}}
                            <div>
                                <button type="button" wire:click="removeItem({{ $idx }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded">×
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- 7) Diskon & Total Harga --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label value="Total Diskon" />
                        <x-input type="text" :value="'Rp ' . number_format($total_diskon, 0, ',', '.')" disabled
                            class="w-full bg-gray-100 rounded shadow-sm" />
                    </div>
                    <div>
                        <x-label value="Total Harga" />
                        <x-input type="text" :value="'Rp ' . number_format($total_harga, 0, ',', '.')" disabled
                            class="w-full bg-gray-100 rounded shadow-sm" />
                    </div>
                </div>

                {{-- 8) Pembayaran & Status --}}
                <div class="grid grid-cols-3 gap-4 mt-6">
                    {{-- Metode Pembayaran --}}
                    <div>
                        <select wire:model.live="metode_pembayaran"
                            class="w-full mt-2 border-gray-300 rounded shadow-sm">
                            <option value="">-- pilih metode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Qris">Qris</option>
                        </select>
                        @error('metode_pembayaran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status Pembayaran --}}
                    <div>
                        <select wire:model.live="status_pembayaran"
                            class="w-full mt-2 border-gray-300 rounded shadow-sm">
                            <option value="">-- pilih status --</option>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                        @error('status_pembayaran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Jumlah Bayar --}}
                    <div>
                        <x-label value="Jumlah Bayar" />
                        <x-input type="number" min="0" step="0.01" wire:model.live="jumlah_bayar"
                            class="w-full rounded shadow-sm" />
                        @error('jumlah_bayar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kembalian --}}
                    <div class="col-span-3 mt-2">
                        <p><strong>Kembalian:</strong> Rp {{ number_format($kembalian, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- 9) Status Transaksi & Keterangan --}}
                <div class="grid grid-cols-1 gap-4 mt-4">
                    <div>
                        <select wire:model.live="status_transaksi"
                            class="w-full mt-2 border-gray-300 rounded shadow-sm">
                            <option value="Diproses">Diproses</option>
                            <option value="Siap Ambil">Siap Ambil</option>
                            <option value="Terambil">Terambil</option>
                        </select>
                        @error('status_transaksi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Keterangan" />
                        <textarea wire:model.live="keterangan" rows="3" class="w-full border-gray-300 rounded shadow-sm px-2 py-1"></textarea>
                    </div>
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('transaksi') }}" class="ml-2 bg-red-600 text-white px-4 py-2 rounded">Batal</a>
        </x-slot>
    </x-form-section>
</div>
