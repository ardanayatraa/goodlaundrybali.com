<div>
    <x-button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 w-full">
        <div class="icon-square-plus"></div>  Tambah Admin
    </x-button>
    
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Tambah Admin</x-slot>
    
        <x-slot name="content">
            <x-input label="Nama Admin" wire:model="nama_admin" class="w-full mt-2"/>
            <x-input label="Username" wire:model="username" class="w-full mt-2"/>
            <x-input label="Password" type="password" wire:model="password" class="w-full mt-2"/>
        </x-slot>
    
        <x-slot name="footer">
            <x-button wire:click="save" class="bg-blue-500">Simpan</x-button>
            <x-button wire:click="$set('showModal', false)" class="bg-gray-500">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
    
</div>