<x-app-layout>
    <div>
        {{-- Header --}}
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                {{-- icon calendar --}}
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Detail Barang Masuk
                <span class="ml-2 font-light">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM YYYY') }}</span>
            </div>
            <div>
                {{ Breadcrumbs::render('trx-barang-masuk.by-date', $tanggal) }}
            </div>
        </div>

        {{-- Livewire Detail by Date --}}
        @livewire('trx-barang-masuk.detail-by-date', ['tanggal' => $tanggal])
    </div>
</x-app-layout>
