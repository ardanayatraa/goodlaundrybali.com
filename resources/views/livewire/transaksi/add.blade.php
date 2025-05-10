<div>
    <x-form-section submit="save">
        <x-slot name="title">
            Tambah Transaksi
        </x-slot>

        <x-slot name="description">
            Silakan isi detail transaksi di bawah ini.
        </x-slot>

        <x-slot name="form">
            <div class="space-y-6">
                <!-- Search Pelanggan -->
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

                <!-- Display Jumlah Point with Button -->
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <x-label for="jumlah_point" value="Jumlah Point" />
                        <x-input id="jumlah_point" type="text" value="{{ $jumlah_point }}"
                            class="w-full mt-2 bg-gray-100" disabled />
                    </div>
                    <div class="mt-6">
                        <button wire:click="usePoints" class="btn btn-primary">Gunakan Poin</button>
                    </div>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                @endif

                <!-- filepath: c:\Users\Ardana Yatra\Documents\Project Mar 2025\goodlaundrybali.com\resources\views\livewire\transaksi\add.blade.php -->
                <div>
                    <x-label for="searchPaket" value="Cari Paket" />
                    @if ($id_paket)
                        <div class="mt-2 flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <span class="text-sm text-gray-700 flex-1">
                                {{ $pakets->firstWhere('id_paket', $id_paket)?->jenis_paket }} /
                                Rp.
                                {{ number_format($pakets->firstWhere('id_paket', $id_paket)?->harga ?? 0, 0, ',', '.') }}
                                /
                                {{ $pakets->firstWhere('id_paket', $id_paket)?->unit }}
                            </span>
                            <button type="button" wire:click="$set('id_paket', null)"
                                class="text-red-500 hover:underline font-bold">
                                &times;
                            </button>
                        </div>
                    @else
                        <x-input id="searchPaket" type="text" wire:model="searchPaket" class="w-full mt-2"
                            placeholder="Ketik jenis paket..." wire:focus="$set('focusedPaket', true)"
                            wire:blur="$set('focusedPaket', false)" />
                        @if ($focusedPaket)
                            <ul class="mt-2 border border-gray-300 rounded-lg max-h-40 overflow-y-auto">
                                @forelse ($pakets as $paket)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                        wire:click="$set('id_paket', '{{ $paket->id_paket }}')">
                                        {{ $paket->jenis_paket }}
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-500">
                                        Tidak ada hasil untuk "{{ $searchPaket }}"
                                    </li>
                                @endforelse
                            </ul>
                        @endif
                    @endif
                    @error('id_paket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <x-label for="tanggal_transaksi" value="Tanggal Transaksi" />
                    <x-input id="tanggal_transaksi" type="date" wire:model="tanggal_transaksi" class="w-full mt-2"
                        value="{{ now()->format('d-m-Y') }}" />
                    @error('tanggal_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <x-label for="jumlah" value="Jumlah" />
                    <x-input id="jumlah" type="number" wire:model="jumlah" class="w-full mt-2" />
                    @error('jumlah')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <x-label for="total_diskon" value="Total Diskon" />
                    <x-input id="total_diskon" type="number" step="0.01" disabled wire:model="total_diskon"
                        class="w-full mt-2" />
                    @error('total_diskon')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Total Harga -->
                <div>
                    <x-label for="total_harga" value="Total Harga" />
                    <x-input id="total_harga" type="number" wire:model="total_harga" class="w-full mt-2" disabled />
                    @error('total_harga')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="metode_pembayaran" value="Metode Pembayaran" />
                    <select id="metode_pembayaran" wire:model="metode_pembayaran"
                        class="border border-gray-300 mt-2 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="Cash">Cash</option>
                        <option value="Qris">Qris</option>
                    </select>
                    @error('metode_pembayaran')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="status_pembayaran" value="Status Pembayaran" />
                    <select id="status_pembayaran" wire:model="status_pembayaran"
                        class="border border-gray-300 mt-2 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Pilih Status Pembayaran</option>
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                    @error('status_pembayaran')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="status_transaksi" value="Status Transaksi" />
                    <select id="status_transaksi" wire:model="status_transaksi"
                        class="border border-gray-300 mt-2 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Pilih Status Transaksi</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Siap Ambil">Siap Ambil</option>
                        <option value="Terambil">Terambil</option>
                    </select>
                    @error('status_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="jumlah_point" value="Jumlah Point (Opsional)" />
                    <x-input id="jumlah_point" type="number" wire:model="jumlah_point" class="w-full mt-2" />
                    @error('jumlah_point')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tanggal_ambil" value="Tanggal Ambil" />
                    <x-input id="tanggal_ambil" type="date" wire:model="tanggal_ambil" class="w-full mt-2" />
                    @error('tanggal_ambil')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="jam_ambil" value="Jam Ambil" />
                    <x-input id="jam_ambil" type="time" wire:model="jam_ambil" class="w-full mt-2" />
                    @error('jam_ambil')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="keterangan" value="Keterangan" />
                    <textarea id="keterangan" wire:model="keterangan"
                        class="border border-gray-300 mt-2 text-gray-900 text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    @error('keterangan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-button type="submit" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <a href="{{ route('transaksi') }}"
                class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                <span>Batal</span>
            </a>
        </x-slot>
    </x-form-section>
</div>
