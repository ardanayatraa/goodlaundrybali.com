<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a4 4 0 00-8 0v2m-2 0a6 6 0 0112 0v2m-5 7h-2m1-3v3" />
                </svg>
                Daftar Transaksi
            </div>
            <div>
                {{ Breadcrumbs::render('transaksi') }}
            </div>
        </div>

        <a href="{{ route('transaksi.add') }}"
            class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Transaksi</span>
        </a>

        @livewire('transaksi.delete')
        @livewire('transaksi.update-status')
        @livewire('transaksi.filter-data')
        @livewire('transaksi.pembayaran-trx')
    </div>
</x-app-layout>
