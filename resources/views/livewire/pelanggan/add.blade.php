<div>
    <x-button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2">
        Tambah Pelanggan
    </x-button>
    
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">Tambah Pelanggan</x-slot>
    
        <x-slot name="content">
            <x-label for="nama_pelanggan" value="Nama Pelanggan"/>
            <x-input id="nama_pelanggan" wire:model="nama_pelanggan" class="mt-2 w-full"/>
    
            <x-label for="no_telp" value="No Telp"/>
            <x-input id="no_telp" wire:model="no_telp" class="mt-2 w-full"/>
    
            <x-label for="alamat" value="Alamat"/>
            <x-input id="alamat" wire:model="alamat" class="mt-2 w-full"/>
    
            <x-label for="keterangan" value="Keterangan"/>
            <x-input id="keterangan" wire:model="keterangan" class="mt-2 w-full"/>
        </x-slot>
    
        <x-slot name="footer">
            <x-button wire:click="save" class="bg-blue-500 text-white">Simpan</x-button>
            <x-button wire:click="closeModal" class="bg-gray-500 text-white">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
    
</div>