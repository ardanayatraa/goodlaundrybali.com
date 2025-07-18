<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Tambah Transaksi
            </div>
            <a href="{{ route('pelanggan.add') }}"
                class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Tambah Pelanggan</span>
            </a>
            <div>
                {{ Breadcrumbs::render('transaksi.add') }}
            </div>
        </div>
        @livewire('transaksi.add')
    </div>
</x-app-layout>
