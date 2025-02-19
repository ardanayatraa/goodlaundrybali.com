<div>
    <x-button wire:click="openModal" class="bg-yellow-500 text-white w-full">Edit Unit</x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Edit Unit</x-slot>

        <x-slot name="content">
            <x-label for="nama_unit" value="Nama Unit" />
            <x-input id="nama_unit" type="text" class="w-full" wire:model.defer="nama_unit" />

            <x-label for="keterangan" value="Keterangan" class="mt-3" />
            <textarea id="keterangan" class="w-full border-gray-300" wire:model.defer="keterangan"></textarea>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update" class="bg-yellow-500">Update</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
