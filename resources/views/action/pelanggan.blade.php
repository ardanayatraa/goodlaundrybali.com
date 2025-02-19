<div>
    @if ($pl->keterangan === 'Member')
    <button onclick="window.location.href='/pelanggan/cetak/{{ $pl->id_pelanggan }}'"
        class="px-4 py-2 text-green-800 rounded-md hover:bg-green-100 focus:outline-none flex items-center space-x-2">
        <i class="fas fa-print"></i>
        <span>Cetak Member</span>
    </button>
    @endif

    @livewire('pelanggan.edit', ['id_pelanggan' => $pl->id_pelanggan])
    @livewire('pelanggan.delete', ['id_pelanggan' => $pl->id_pelanggan])

</div>