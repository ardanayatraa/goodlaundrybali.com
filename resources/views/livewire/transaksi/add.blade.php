<div>
    <x-button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2">
        Tambah Transaksi
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Transaksi
        </x-slot>

        <x-slot name="content">
            <x-label for="id_pelanggan" value="Pelanggan" />
            <x-input wire:model="id_pelanggan" type="number" class="w-full mt-2"/>

            <x-label for="id_point" value="Point (Opsional)" />
            <x-input wire:model="id_point" type="number" class="w-full mt-2"/>

            <x-label for="id_paket" value="Paket" />
            <x-input wire:model="id_paket" type="number" class="w-full mt-2"/>

            <x-label for="tanggal_transaksi" value="Tanggal Transaksi" />
            <x-input wire:model="tanggal_transaksi" type="date" class="w-full mt-2"/>

            <x-label for="total_harga" value="Total Harga" />
            <x-input wire:model="total_harga" type="number" class="w-full mt-2"/>

            <x-label for="metode_pembayaran" value="Metode Pembayaran" />
            <x-input wire:model="metode_pembayaran" class="w-full mt-2"/>

            <x-label for="status_pembayaran" value="Status Pembayaran" />
            <x-input wire:model="status_pembayaran" class="w-full mt-2"/>

            <x-label for="status_transaksi" value="Status Transaksi" />
            <x-input wire:model="status_transaksi" class="w-full mt-2"/>

            <x-label for="jumlah_point" value="Jumlah Point (Opsional)" />
            <x-input wire:model="jumlah_point" type="number" class="w-full mt-2"/>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500 text-white px-4 py-2">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
