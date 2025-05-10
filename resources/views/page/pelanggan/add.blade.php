<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Tambah Pelanggan
            </div>
            <div>
                {{ Breadcrumbs::render('pelanggan.add') }}
            </div>
        </div>
        @livewire('pelanggan.add')
    </div>
</x-app-layout>
