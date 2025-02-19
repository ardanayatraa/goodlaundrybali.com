<div>
    <x-button wire:click="openModal" class="bg-blue-500 text-white w-full">Tambah Barang Masuk</x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Tambah Barang Masuk</x-slot>

        <x-slot name="content">
            <x-label for="id_barang" value="ID Barang" />
            <x-input id="id_barang" type="number" class="w-full" wire:model.defer="id_barang" />

            <x-label for="jumlah" value="Jumlah" class="mt-3" />
            <x-input id="jumlah" type="number" class="w-full" wire:model.defer="jumlah" />

            <x-label for="tanggal_masuk" value="Tanggal Masuk" class="mt-3" />
            <x-input id="tanggal_masuk" type="date" class="w-full" wire:model.defer="tanggal_masuk" />
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save" class="bg-blue-500">Simpan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
