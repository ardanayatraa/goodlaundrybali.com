<div>
    <x-button wire:click="openModal" class="bg-red-500 text-white px-4 py-2">
        Hapus Detail Transaksi
    </x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Konfirmasi Hapus
        </x-slot>

        <x-slot name="content">
            <p>Apakah Anda yakin ingin menghapus detail transaksi ini?</p>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="delete" class="bg-red-500 text-white px-4 py-2">Hapus</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500 text-white px-4 py-2">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
