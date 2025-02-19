
      <div>
        <a href="{{ route('trx-barang-keluar.edit', ['id_trx-barang-keluar' => $trxBarangKeluar->id_trx_brgkeluar]) }}" 
          class="inline-flex items-center gap-2 px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
           <i data-lucide="pencil" class="w-5 h-5"></i>
           <span>Edit</span>
       </a>
       
      @livewire('trx-barang-keluar.delete', ['id_trx_barang_keluar' => $trxBarangKeluar->id_trx_brgkeluar])
  
    </div>

  