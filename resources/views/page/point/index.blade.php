<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m9-5a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Daftar Point
            </div>
            <div>
                {{ Breadcrumbs::render('point') }}
            </div>
        </div>

        <a href="{{ route('point.add') }}"
            class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Point</span>
        </a>

        @livewire('point.delete')
        @livewire('table.point-table')
    </div>
</x-app-layout>
