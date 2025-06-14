<div class="p-4">
    <div class="filters mb-6 bg-white shadow rounded-lg p-4">
        <div class="mb-4">
            <label for="filterRange" class="block text-sm font-medium text-gray-700">Rentang Tanggal Pendaftaran</label>
            <div class="flex flex-col md:flex-row md:space-x-2 mt-1">
                <input type="date" wire:model="filterStartDate"
                    class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <input type="date" wire:model="filterEndDate"
                    class="form-input w-full mt-2 md:mt-0 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <button wire:click="applyFilter" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Terapkan Filter
            </button>

            @if ($apply)
                <button wire:click="generatePdf" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Export PDF
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-4">
        @livewire('table.laporan-pelanggan-table', [
            'filterStartDate' => $filterStartDate,
            'filterEndDate' => $filterEndDate,
        ])
    </div>
</div>
