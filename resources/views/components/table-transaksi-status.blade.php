<div class="w-30">
    <button wire:click="$emit('editStatus', {{ $id }})"
        class="w-full px-3 py-1.5 rounded-lg text-white font-medium text-sm text-center transition
               {{ match ($status) {
                   'diproses' => 'bg-yellow-500 hover:bg-yellow-600',
                   'siap_ambil' => 'bg-blue-500 hover:bg-blue-600',
                   'terambil' => 'bg-green-500 hover:bg-green-600',
                   default => 'bg-green-500 hover:bg-graan-600',
               } }} ">
        {{ match ($status) {
            'diproses' => '⚙️ Diproses',
            'siap_ambil' => '📦 Siap Ambil',
            'terambil' => '✅ Terambil',
            default => ucfirst($status),
        } }}
    </button>
</div>
