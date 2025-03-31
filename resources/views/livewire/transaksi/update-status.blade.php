<div>
    <x-dialog-modal wire:model.defer="id_transaksi">
        <x-slot name="title">Update Status Transaksi</x-slot>

        <x-slot name="content">
            <x-label for="status_transaksi" value="Status Transaksi" />
            <select wire:model="status_transaksi" id="status_transaksi"
                class="w-full mt-2 p-2 border rounded-lg bg-white dark:bg-gray-800 dark:text-white 
                       focus:ring focus:ring-blue-500 focus:outline-none transition duration-200">
                <option value="diproses" class="text-yellow-500">⚙️ Diproses</option>
                <option value="siap_ambil" class="text-blue-500">📦 Siap Ambil</option>
                <option value="terambil" class="text-green-500">✅ Terambil</option>
            </select>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('id_transaksi', null)">Close</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
