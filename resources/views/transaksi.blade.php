<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                Transaksi
            </div>
            <div>
                {!! Breadcrumbs::render('transasksi') !!}
            </div>
        </div>
   
        <livewire:transaksi.add />
        <livewire:table.transaksi-table />
    </div>
</x-app-layout>
