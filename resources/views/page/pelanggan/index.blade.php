<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 21v-2a4 4 0 00-8 0v2M12 11a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
                Daftar Pelanggan
            </div>
            <div>
                {{ Breadcrumbs::render('pelanggan') }}
            </div>
        </div>

        <a href="{{ route('pelanggan.add') }}"
            class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Pelanggan</span>
        </a>

        @livewire('pelanggan.delete')
        @livewire('table.pelanggan-table')
    </div>
</x-app-layout>
