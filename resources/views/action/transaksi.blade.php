<div>
    <!-- Button to trigger modal for Edit and Delete -->
    <div class="flex space-x-4">
        <!-- Edit Button -->
        <button onclick="openEditModal({{ $transaksi->id_transaksi }})" 
                class="px-4 py-2 text-blue-800 rounded-md hover:bg-blue-100 focus:outline-none flex items-center space-x-2">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </button>

        <!-- Delete Button -->
        <button onclick="openDeleteModal({{ $transaksi->id_transaksi }}, '{{ $transaksi->nama_pelanggan }}')" 
                class="px-4 py-2 text-red-800 rounded-md hover:bg-red-100 focus:outline-none flex items-center space-x-2">
            <i class="fas fa-trash-alt"></i>
            <span>Hapus</span>
        </button>
    </div>
</div>

<!-- Modal for Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Edit Transaksi</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="editForm" action="{{ route('transaksi.update', ['id' => $transaksi->id_transaksi]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Pelanggan</label>
                    <input 
                        type="text" 
                        name="nama_pelanggan"
                        value="{{ old('nama_pelanggan', $transaksi->nama_pelanggan) }}"
                        placeholder="Masukkan nama pelanggan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Tanggal Transaksi</label>
                    <input 
                        type="date" 
                        name="tanggal_transaksi"
                        value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Total Harga</label>
                    <input 
                        type="number" 
                        name="total_harga"
                        value="{{ old('total_harga', $transaksi->total_harga) }}"
                        placeholder="Masukkan total harga"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Metode Pembayaran</label>
                    <input 
                        type="text" 
                        name="metode_pembayaran"
                        value="{{ old('metode_pembayaran', $transaksi->metode_pembayaran) }}"
                        placeholder="Masukkan metode pembayaran"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="status_pembayaran" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="lunas" {{ $transaksi->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum_lunas" {{ $transaksi->status_pembayaran == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Status Transaksi</label>
                    <select name="status_transaksi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="selesai" {{ $transaksi->status_transaksi == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="belum_selesai" {{ $transaksi->status_transaksi == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Jumlah Point</label>
                    <input 
                        type="number" 
                        name="jumlah_point"
                        value="{{ old('jumlah_point', $transaksi->jumlah_point) }}"
                        placeholder="Masukkan jumlah point"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Status Bonus</label>
                    <select name="status_bonus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="ya" {{ $transaksi->status_bonus == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ $transaksi->status_bonus == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeEditModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Delete -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold text-gray-900">Delete Confirmation</h2>
        <h2 class="text-xl font-semibold text-gray-900" id="deleteItemName"></h2>
        <p class="mt-2 text-gray-600">Are you sure you want to delete this item? This action cannot be undone.</p>
        <div class="mt-4 flex justify-end space-x-2">
            <form id="deleteForm" action="{{ route('transaksi.delete', ['id' => $transaksi->id_transaksi]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none">Yes, Delete</button>
            </form>
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400 focus:outline-none">Cancel</button>
        </div>
    </div>
</div>

<script>
    function openEditModal(id) {
        document.getElementById('editForm').action = `/transaksi/update/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Disable scrolling when modal is open
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteForm').action = `/transaksi/delete/${id}`;
        document.getElementById('deleteItemName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Disable scrolling when modal is open
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }

    // Close modal when clicking on overlay
    window.addEventListener('click', function (event) {
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
</script>
