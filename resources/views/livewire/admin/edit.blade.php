<div>
    <x-button wire:click="openModal" class="bg-yellow-500 text-white px-4 py-2 w-full">
        Edit Admin
    </x-button>
    
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Edit Admin</x-slot>
    
        <x-slot name="content">
            <x-input label="Nama Admin" wire:model="nama_admin" class="w-full mt-2"/>
            <x-input label="Username" wire:model="username" class="w-full mt-2"/>
        </x-slot>
    
        <x-slot name="footer">
            <x-button wire:click="update" class="bg-yellow-500">Update</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
    
</div>