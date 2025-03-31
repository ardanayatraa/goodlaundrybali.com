<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 14l6-6m0 0l-6-6m6 6H3m12 6h6m-6 6h6m-6-6h6" />
                </svg>
                Detail Transaksi
            </div>
            <div>
                {{ Breadcrumbs::render('detail-transaksi') }}
            </div>
        </div>

        <a href="{{ route('detail-transaksi.add') }}"
            class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Detail Transaksi</span>
        </a>

        @livewire('detail-transaksi.delete')
        @livewire('table.detail-transaksi-table')
    </div>
</x-app-layout>
