<div>
    <x-button wire:click="openModal" class="bg-yellow-500 text-white w-full">
        Edit Point
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Edit Point</x-slot>

        <x-slot name="content">
            <x-label for="id_pelanggan" value="Pelanggan" />
            <x-input id="id_pelanggan" wire:model="id_pelanggan" type="number" class="w-full mt-2"/>

            <x-label for="tanggal" value="Tanggal" />
            <x-input id="tanggal" wire:model="tanggal" type="date" class="w-full mt-2"/>

            <x-label for="jumlah_point" value="Jumlah Point" />
            <x-input id="jumlah_point" wire:model="jumlah_point" type="number" class="w-full mt-2"/>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update" class="bg-yellow-500">Simpan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
