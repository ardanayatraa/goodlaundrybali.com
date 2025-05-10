<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h11M9 21V3m-6 6l3-3m3 3l-3-3" />
                </svg>
                Tambah Unit
            </div>
            <div>
                {{ Breadcrumbs::render('unit.add') }}
            </div>
        </div>
        @livewire('unit.add')
    </div>
</x-app-layout>
