<div>
    <x-button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2">
        Tambah Detail Transaksi
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Tambah Detail Transaksi
        </x-slot>

        <x-slot name="content">
            <x-label for="id_transaksi" value="ID Transaksi" />
            <x-input wire:model="id_transaksi" type="number" class="w-full mt-2"/>

            <x-label for="id_paket" value="ID Paket" />
            <x-input wire:model="id_paket" type="number" class="w-full mt-2"/>

            <x-label for="jumlah" value="Jumlah" />
            <x-input wire:model="jumlah" type="number" class="w-full mt-2"/>

            <x-label for="subtotal" value="Subtotal" />
            <x-input wire:model="subtotal" type="number" class="w-full mt-2"/>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save" class="bg-blue-500 text-white px-4 py-2">Simpan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500 text-white px-4 py-2">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
