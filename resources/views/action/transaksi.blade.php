<div>

  <a href="{{ route('transaksi.edit', ['id' => $transaksi->id_paket]) }}" 
    class="inline-flex items-center gap-2 px-3 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
     <i data-lucide="pencil" class="w-5 h-5"></i>
     <span>Edit</span>
 </a>
    @livewire('transaksi.delete', ['id_transaksi' => $id])


  </div>

