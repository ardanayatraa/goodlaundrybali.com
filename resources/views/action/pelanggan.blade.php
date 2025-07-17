<div class="flex items-center gap-2">
    @if ($pl->keterangan === 'Member')
        <button onclick="window.location.href='/pelanggan/cetak/{{ $pl->no_telp }}'"
            class="w-[140px] px-3 py-1.5 text-green-500 rounded-lg hover:text-green-600 flex items-center gap-2 transition">
            <i class="fas fa-print"></i>
            <span>Cetak Member</span>
        </button>
    @else
        <button
            class="w-[140px] px-3 py-1.5 disable text-red-500 rounded-lg hover:text-red-600 flex items-center gap-2 transition">
            <i class="fas fa-print"></i>
            <span>Bukan Member</span>
        </button>
    @endif

    @include('components.edit-action', ['id' => $pl->no_telp, 'route' => $route])
    @include('components.delete-action', ['id' => $pl->no_telp])
</div>
