<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 17l4-4m0 0l-4-4m4 4H3m13 0h8" />
                </svg>
                Detail Transaksi
            </div>

            <a href="{{ route('pelanggan.add') }}"
                class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Tambah Pelanggan</span>
            </a>

            <div>
                {{ Breadcrumbs::render('transaksi.detail', $id) }}
            </div>
        </div>

        @livewire('transaksi.detail', ['transaksiId' => $id])
    </div>
</x-app-layout>
