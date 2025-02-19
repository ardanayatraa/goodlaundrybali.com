<div>
    <x-button wire:click="openModal" class="bg-blue-500 text-white w-full">Tambah Unit</x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Tambah Unit</x-slot>

        <x-slot name="content">
            <x-label for="nama_unit" value="Nama Unit" />
            <x-input id="nama_unit" type="text" class="w-full" wire:model.defer="nama_unit" />

            <x-label for="keterangan" value="Keterangan" class="mt-3" />
            <textarea id="keterangan" class="w-full border-gray-300" wire:model.defer="keterangan"></textarea>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save" class="bg-blue-500">Simpan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
