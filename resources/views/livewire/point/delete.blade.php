<div>
    <x-button wire:click="openModal" class="bg-red-500 text-white w-full">
        Hapus Point
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Hapus Point</x-slot>

        <x-slot name="content">
            <p>Apakah Anda yakin ingin menghapus point ini?</p>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="delete" class="bg-red-500">Hapus</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
