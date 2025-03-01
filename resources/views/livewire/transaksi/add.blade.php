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
                <div>
                    <x-label for="id_pelanggan" value="Pelanggan" />
                    <x-input id="id_pelanggan" type="number" wire:model="id_pelanggan" class="w-full mt-2" />
                    @error('id_pelanggan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="id_point" value="Point (Opsional)" />
                    <x-input id="id_point" type="number" wire:model="id_point" class="w-full mt-2" />
                    @error('id_point')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="id_paket" value="Paket" />
                    <x-input id="id_paket" type="number" wire:model="id_paket" class="w-full mt-2" />
                    @error('id_paket')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tanggal_transaksi" value="Tanggal Transaksi" />
                    <x-input id="tanggal_transaksi" type="date" wire:model="tanggal_transaksi" class="w-full mt-2" />
                    @error('tanggal_transaksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="total_harga" value="Total Harga" />
                    <x-input id="total_harga" type="number" wire:model="total_harga" class="w-full mt-2" />
                    @error('total_harga')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="metode_pembayaran" value="Metode Pembayaran" />
                    <x-input id="metode_pembayaran" wire:model="metode_pembayaran" class="w-full mt-2" />
                    @error('metode_pembayaran')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="status_pembayaran" value="Status Pembayaran" />
                    <x-input id="status_pembayaran" wire:model="status_pembayaran" class="w-full mt-2" />
                    @error('status_pembayaran')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="status_transaksi" value="Status Transaksi" />
                    <x-input id="status_transaksi" wire:model="status_transaksi" class="w-full mt-2" />
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
