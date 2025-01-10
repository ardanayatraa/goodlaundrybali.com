<div>
    <!-- Tombol untuk membuka modal -->
    <button 
        wire:click="openModal" 
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
    >
        Tambah Pelanggan
    </button>

    <!-- Modal -->
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">Tambah Pelanggan</h2>

                <!-- Form -->
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">
                            Nama Pelanggan
                        </label>
                        <input 
                            type="text" 
                            id="nama_pelanggan" 
                            wire:model="nama_pelanggan" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        @error('nama_pelanggan') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">
                            Nomor Telepon
                        </label>
                        <input 
                            type="text" 
                            id="no_telp" 
                            wire:model="no_telp" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        />
                        @error('no_telp') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">
                            Alamat
                        </label>
                        <textarea 
                            id="alamat" 
                            wire:model="alamat" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        ></textarea>
                        @error('alamat') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">
                            Keterangan
                        </label>
                        <textarea 
                            id="keterangan" 
                            wire:model="keterangan" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        ></textarea>
                        @error('keterangan') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded ml-2 hover:bg-blue-600"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
