<div>
    <x-form-section submit="save">
        <x-slot name="title">Tambah Transaksi</x-slot>
        <x-slot name="description">Isi data transaksi dan pembayaran.</x-slot>

        <x-slot name="form">
            <div class="space-y-6">

                {{-- 1) Cari Pelanggan - FIXED --}}
                <div class="relative" x-data="{ open: @entangle('focusedPelanggan') }">
                    <x-label for="searchPelanggan" value="Cari Pelanggan" />
                    @if ($no_telp && isset($selectedPelanggan))
                        <div class="mt-2 flex items-center gap-2 border rounded px-3 py-2 bg-white">
                            <div class="flex-1">
                                <div class="font-medium">{{ $selectedPelanggan->nama_pelanggan }}</div>
                                <div class="text-sm text-gray-500">{{ $selectedPelanggan->no_telp }} •
                                    {{ $selectedPelanggan->point }} Poin</div>
                            </div>
                            <button wire:click="$set('no_telp',null)" type="button"
                                class="text-red-500 hover:text-red-700">&times;</button>
                        </div>
                    @else
                        <x-input id="searchPelanggan" wire:model.live="searchPelanggan"
                            placeholder="Ketik nama atau nomor telepon pelanggan..." @focus="open = true"
                            @blur="setTimeout(() => open = false, 200)" class="w-full mt-2" />

                        <div x-show="open"
                            class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                            @if (empty($searchPelanggan))
                                <div class="px-4 py-2 bg-gray-50 border-b text-xs text-gray-600 font-medium">
                                    Pelanggan Terbaru
                                </div>
                            @endif
                            @forelse($pelanggans as $p)
                                <div class="px-4 py-2 text-left hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0"
                                    @click="$wire.set('no_telp', '{{ $p->no_telp }}'); open = false">
                                    <div class="font-medium">{{ $p->nama_pelanggan }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $p->no_telp }} • {{ $p->point }} Poin
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-2 text-gray-500 text-sm">
                                    @if (empty($searchPelanggan))
                                        Belum ada pelanggan
                                    @else
                                        Tidak ada hasil ditemukan
                                    @endif
                                </div>
                            @endforelse
                        </div>
                    @endif
                    @error('no_telp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Click outside to close dropdown - Not needed with Alpine.js --}}

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
                    <button wire:click="usePoints" type="button"
                        class="bg-blue-500 text-white px-4 py-2 rounded mt-6 hover:bg-blue-600">
                        Gunakan Poin
                    </button>
                </div>
                @if (session('success'))
                    <div class="text-green-600 bg-green-50 p-2 rounded">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="text-red-600 bg-red-50 p-2 rounded">{{ session('error') }}</div>
                @endif
                @if ($pointsToRedeem)
                    <div class="text-gray-700 bg-blue-50 p-2 rounded">
                        Poin dipakai: <strong>{{ $pointsToRedeem }}</strong> → Diskon Rp
                        {{ number_format($total_diskon, 0, ',', '.') }}
                    </div>
                @endif

                {{-- 4) Opsi Pickup --}}
                <div>
                    <x-label value="Tanggal/Jam Ambil" />
                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model.live="samePickup" value="1" class="form-radio" />
                            <span class="ml-2">Sama untuk semua</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model.live="samePickup" value="0" class="form-radio" />
                            <span class="ml-2">Atur per paket</span>
                        </label>
                    </div>
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
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">Daftar Paket</h3>
                        <button wire:click="addItem" type="button"
                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            + Tambah Paket
                        </button>
                    </div>

                    {{-- Header --}}
                    <div
                        class="{{ $samePickup ? 'grid grid-cols-5' : 'grid grid-cols-7' }} gap-4 mb-2 text-sm font-medium text-gray-700">
                        <div>Paket</div>
                        <div>Harga</div>
                        <div>Jumlah</div>
                        @unless ($samePickup)
                            <div>Tgl Ambil</div>
                            <div>Jam Ambil</div>
                        @endunless
                        <div>Subtotal</div>
                        <div>Aksi</div>
                    </div>

                    @foreach ($items as $idx => $row)
                        <div wire:key="item-{{ $idx }}"
                            class="{{ $samePickup ? 'grid grid-cols-5' : 'grid grid-cols-7' }} gap-4 mb-4 items-start">
                            <div>
                                <select wire:model.live="items.{{ $idx }}.id_paket"
                                    class="w-full border-gray-300 rounded">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($pakets as $p)
                                        <option value="{{ $p->id_paket }}">
                                            {{ $p->jenis_paket }} – Rp {{ number_format($p->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error("items.$idx.id_paket")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input type="text" value="Rp {{ number_format($row['harga'] ?? 0, 0, ',', '.') }}"
                                    disabled class="w-full bg-gray-100" />
                            </div>
                            <div>
                                <x-input type="number" min="1"
                                    wire:model.live="items.{{ $idx }}.jumlah" class="w-full" />
                                @error("items.$idx.jumlah")
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @unless ($samePickup)
                                <div>
                                    <x-input type="date" wire:model.live="items.{{ $idx }}.tanggal_ambil"
                                        class="w-full" />
                                    @error("items.$idx.tanggal_ambil")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <x-input type="time" wire:model.live="items.{{ $idx }}.jam_ambil"
                                        class="w-full" />
                                    @error("items.$idx.jam_ambil")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endunless
                            <div>
                                <x-input type="text"
                                    value="Rp {{ number_format($row['subtotal'] ?? 0, 0, ',', '.') }}" disabled
                                    class="w-full bg-gray-100" />
                            </div>
                            <div>
                                <button wire:click="removeItem({{ $idx }})" type="button"
                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- 7) Diskon & Total Harga --}}
                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded">
                    <div>
                        <x-label value="Total Diskon" />
                        <x-input type="text" :value="'Rp ' . number_format($total_diskon, 0, ',', '.')" disabled class="w-full bg-gray-100 font-medium" />
                    </div>
                    <div>
                        <x-label value="Total Harga" />
                        <x-input type="text" :value="'Rp ' . number_format($total_harga, 0, ',', '.')" disabled
                            class="w-full bg-gray-100 font-bold text-lg" />
                    </div>
                </div>

                {{-- 8) Pembayaran & Status --}}
                <div class="grid grid-cols-3 gap-4 mt-6">
                    <div>
                        <x-label value="Metode Pembayaran" />
                        <select wire:model.live="metode_pembayaran" class="w-full mt-1 border-gray-300 rounded">
                            <option value="">-- Pilih Metode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Qris">QRIS</option>
                        </select>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Status Pembayaran" />
                        <select wire:model.live="status_pembayaran" class="w-full mt-1 border-gray-300 rounded">
                            <option value="">-- Pilih Status --</option>
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
                        <p class="text-lg font-medium">
                            <strong>Kembalian:</strong>
                            <span class="{{ $kembalian >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($kembalian, 0, ',', '.') }}
                            </span>
                        </p>
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
                        <textarea wire:model.live="keterangan" rows="3" class="w-full border-gray-300 rounded px-3 py-2"
                            placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                    </div>
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button class="bg-blue-600 text-white px-6 py-2 hover:bg-blue-700">Simpan Transaksi</x-button>
            <a href="{{ route('transaksi') }}"
                class="ml-2 bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Batal</a>
        </x-slot>
    </x-form-section>
</div>
