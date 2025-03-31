<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Daftar Unit Paket
            </div>
            <div>
                {{ Breadcrumbs::render('unit-paket') }}
            </div>
        </div>

        <a href="{{ route('unit-paket.add') }}"
            class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Unit Paket</span>
        </a>

        @livewire('unit-paket.delete')
        @livewire('table.unit-paket-table')
    </div>
</x-app-layout>
