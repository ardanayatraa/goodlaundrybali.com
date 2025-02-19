<div>
    <x-button wire:click="openModal" class="bg-red-500 text-white px-4 py-2">
        Hapus Paket
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Konfirmasi Hapus</x-slot>

        <x-slot name="content">
            Apakah Anda yakin ingin menghapus paket ini?
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="delete" class="bg-red-500">Hapus</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
