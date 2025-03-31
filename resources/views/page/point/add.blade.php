<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m9-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Point
            </div>
            <div>
                {{ Breadcrumbs::render('point.add') }}
            </div>
        </div>
        @livewire('point.add')
    </div>
</x-app-layout>
