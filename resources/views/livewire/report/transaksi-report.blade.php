<div class="p-4">
    <div class="filters  mb-6 bg-white shadow rounded-lg p-4">
        <div class="mb-4">
            <label for="filterType" class="block text-sm font-medium text-gray-700">Filter Berdasarkan</label>
            <select id="filterType" wire:model="filterType"
                class="form-select w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="daily">Harian</option>
                <option value="weekly">Mingguan</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
                <option value="range">Rentang Tanggal</option>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if ($filterType === 'daily')
                <div>
                    <label for="filterDate" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" id="filterDate" wire:model="filterDate"
                        class="form-input w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            @elseif ($filterType === 'weekly')
                <div>
                    <label for="filterWeek" class="block text-sm font-medium text-gray-700">Minggu</label>
                    <input type="date" id="filterWeek" wire:model="filterWeek"
                        class="form-input w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            @elseif ($filterType === 'monthly')
                <div>
                    <label for="filterMonth" class="block text-sm font-medium text-gray-700">Bulan</label>
                    <input type="month" id="filterMonth" wire:model="filterMonth"
                        class="form-input w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            @elseif ($filterType === 'yearly')
                <div>
                    <label for="filterYear" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <input type="text" id="filterYear" wire:model="filterYear"
                        class="form-input w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            @elseif ($filterType === 'range')
                <div>
                    <label for="filterStartDate" class="block text-sm font-medium text-gray-700">Rentang Tanggal</label>
                    <div class="flex flex-col md:flex-row md:space-x-2 mt-1">
                        <input type="date" id="filterStartDate" wire:model="filterStartDate"
                            class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <input type="date" id="filterEndDate" wire:model="filterEndDate"
                            class="form-input w-full mt-2 md:mt-0 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col md:flex-row gap-2 mt-4">
            <button wire:click="applyFilter"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Apply
            </button>

            @if ($apply)
                <button wire:click="generatePdf"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Generate PDF
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-4">
        @livewire('table.laporan-table', [
            'filterType' => $filterType,
            'filterDate' => $filterDate,
            'filterYear' => $filterYear,
            'filterMonth' => $filterMonth,
            'filterWeek' => $filterWeek,
            'filterStartDate' => $filterStartDate,
            'filterEndDate' => $filterEndDate,
        ])
    </div>
</div>
