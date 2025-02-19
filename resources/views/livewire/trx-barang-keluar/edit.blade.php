<div>
    <x-button wire:click="openModal" class="bg-yellow-500 text-white w-full">Edit Barang Keluar</x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Edit Barang Keluar</x-slot>

        <x-slot name="content">
            <x-label for="id_barang" value="ID Barang" />
            <x-input id="id_barang" type="number" class="w-full" wire:model.defer="id_barang" />

            <x-label for="jumlah" value="Jumlah" class="mt-3" />
            <x-input id="jumlah" type="number" class="w-full" wire:model.defer="jumlah" />

            <x-label for="tanggal_keluar" value="Tanggal Keluar" class="mt-3" />
            <x-input id="tanggal_keluar" type="date" class="w-full" wire:model.defer="tanggal_keluar" />
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update" class="bg-yellow-500">Simpan Perubahan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
