<div>
    <x-button wire:click="openModal" class="bg-red-500 text-white px-4 py-2">
        Hapus Pelanggan
    </x-button>
    
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Hapus Pelanggan</x-slot>
    
        <x-slot name="content">
            Apakah Anda yakin ingin menghapus pelanggan ini?
        </x-slot>
    
        <x-slot name="footer">
            <x-button wire:click="delete" class="bg-red-500 text-white">Hapus</x-button>
            <x-button wire:click="closeModal" class="bg-gray-500 text-white">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
    
</div>
