<x-app-layout>
    <div>
        <div class="flex items-center p-4 border rounded-lg mb-8 justify-between">
            <div class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Barang Masuk
            </div>
            <div>
                {{ Breadcrumbs::render('trx-barang-masuk') }}
            </div>
        </div>

        <a href="{{ route('trx-barang-masuk.add') }}"
            class="inline-flex items-center mb-4 gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Tambah Barang Masuk</span>
        </a>

        @livewire('trx-barang-masuk.delete')

        {{-- Tabs --}}
        <div class="space-y-4">
            <div class="flex border-b border-gray-200">
                <button data-tab="perBarang"
                    class="tab-btn border-b-2 px-4 mr-4 font-medium cursor-pointer border-green-600 text-green-600">
                    Data per Barang
                </button>
                <button data-tab="perTanggal"
                    class="tab-btn border-b-2 px-4 font-medium cursor-pointer border-transparent text-gray-600">
                    Data per Tanggal
                </button>
            </div>

            <div>
                <div data-content="perBarang">
                    @livewire('table.trx-barang-masuk-table')
                </div>
                <div data-content="perTanggal" class="hidden">
                    <livewire:table.group-trx-barang-masuk-table />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = document.querySelectorAll('[data-content]');

            tabs.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-tab');

                    // Toggle active tab styles
                    tabs.forEach(b => {
                        if (b === btn) {
                            b.classList.add('border-green-600', 'text-green-600');
                            b.classList.remove('border-transparent', 'text-gray-600');
                        } else {
                            b.classList.remove('border-green-600', 'text-green-600');
                            b.classList.add('border-transparent', 'text-gray-600');
                        }
                    });

                    // Show/hide panels
                    contents.forEach(panel => {
                        panel.getAttribute('data-content') === target ?
                            panel.classList.remove('hidden') :
                            panel.classList.add('hidden');
                    });
                });
            });
        });
    </script>
</x-app-layout>
