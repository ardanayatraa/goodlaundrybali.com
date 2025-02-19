<div>
    <x-button wire:click="openModal" class="bg-yellow-500 text-white w-full">Edit Unit Paket</x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Edit Unit Paket</x-slot>

        <x-slot name="content">
            <x-label for="id_paket" value="ID Paket" />
            <x-input id="id_paket" type="number" class="w-full" wire:model.defer="id_paket" />

            <x-label for="id_unit" value="ID Unit" class="mt-3" />
            <x-input id="id_unit" type="number" class="w-full" wire:model.defer="id_unit" />

            <x-label for="jumlah" value="Jumlah" class="mt-3" />
            <x-input id="jumlah" type="number" class="w-full" wire:model.defer="jumlah" />
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update" class="bg-yellow-500">Simpan Perubahan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
