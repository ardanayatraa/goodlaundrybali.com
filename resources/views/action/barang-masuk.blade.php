
<div>
  <a href="{{ route('trx-barang-masuk.edit', ['id_trx-barang-masuk' => $trxBarangMasuk->id_trx_brgmasuk]) }}" 
    class="inline-flex items-center gap-2 px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
     <i data-lucide="pencil" class="w-5 h-5"></i>
     <span>Edit</span>
 </a>
    @livewire('trx-barang-masuk.delete', ['id_trx_barang_masuk' => $trxBarangMasuk->id_trx_brgmasuk])

  </div>

