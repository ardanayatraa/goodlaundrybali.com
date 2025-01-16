<div>
    <!-- Button to trigger modal for Edit, Delete, and Cetak Member -->
    <div class="flex space-x-4">
        <!-- Print Member Button (Visible if keterangan is 'member') -->
        @if ($pl->keterangan === 'member')
            <button onclick="window.location.href='/pelanggan/cetak/{{ $pl->id_pelanggan }}'"
                class="px-4 py-2 text-green-800 rounded-md hover:bg-green-100 focus:outline-none flex items-center space-x-2">
                <i class="fas fa-print"></i>
                <span>Cetak Member</span>
            </button>
        @endif

        <!-- Edit Button -->
        <button onclick="openEditModal(this)" data-id="{{ $pl->id_pelanggan }}" data-nama="{{ $pl->nama_pelanggan }}"
            data-telp="{{ $pl->no_telp }}" data-alamat="{{ $pl->alamat }}" data-keterangan="{{ $pl->keterangan }}"
            class="px-4 py-2 text-blue-800 rounded-md hover:bg-blue-100 focus:outline-none flex items-center space-x-2">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </button>

        <!-- Delete Button -->
        <button onclick="openDeleteModal({{ $pl->id_pelanggan }}, '{{ $pl->nama_pelanggan }}')"
            class="px-4 py-2 text-red-800 rounded-md hover:bg-red-100 focus:outline-none flex items-center space-x-2">
            <i class="fas fa-trash-alt"></i>
            <span>Hapus</span>
        </button>


    </div>
</div>

<!-- Modal for Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50"
    onclick="closeOnOverlayClick(event, 'editModal')">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Edit Pelanggan</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pl->nama_pelanggan) }}"
                        placeholder="Masukkan nama pelanggan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $pl->no_telp) }}"
                        placeholder="Masukkan nomor telepon"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Alamat</label>
                    <input name="alamat" value="{{ old('alamat', $pl->alamat) }}" placeholder="Masukkan alamat"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Keterangan</label>
                    <input name="keterangan" value="{{ old('keterangan', $pl->keterangan) }}"
                        placeholder="Masukkan keterangan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50 hidden"
    onclick="closeOnOverlayClick(event, 'deleteModal')">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
        <h2 class="text-xl font-semibold text-gray-900">Konfirmasi Hapus</h2>
        <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menghapus pelanggan <span id="deleteItemName"></span>?
            Tindakan ini tidak dapat dibatalkan.</p>
        <div class="mt-4 flex justify-end space-x-2">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none">Ya,
                    Hapus</button>
            </form>
            <button onclick="closeDeleteModal()"
                class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400 focus:outline-none">Batal</button>
        </div>
    </div>
</div>

<script>
    function openEditModal(button) {
        // Get data from button's data attributes
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const telp = button.getAttribute('data-telp');
        const alamat = button.getAttribute('data-alamat');
        const keterangan = button.getAttribute('data-keterangan');

        // Set the form action URL
        document.getElementById('editForm').action = `/pelanggan/update/${id}`;

        // Set the form input values
        document.querySelector('input[name="nama_pelanggan"]').value = nama;
        document.querySelector('input[name="no_telp"]').value = telp;
        document.querySelector('input[name="alamat"]').value = alamat;
        document.querySelector('input[name="keterangan"]').value = keterangan;

        // Show the modal
        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Disable scrolling
    }

    function openDeleteModal(id_pelanggan, name) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/pelanggan/delete/${id_pelanggan}`;
        document.getElementById('deleteItemName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function closeOnOverlayClick(event, modalId) {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }
</script>
