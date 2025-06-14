<?php

namespace App\Http\Livewire\Report;

use App\Models\Pelanggan;
use Livewire\Component;
use Carbon\Carbon;

class PelangganReport extends Component
{
    public $filterStartDate, $filterEndDate, $apply = false;

    public function applyFilter()
    {
        $this->apply = true;
        $this->emit('filterUpdated', [
            'filterStartDate' => $this->filterStartDate,
            'filterEndDate' => $this->filterEndDate,
        ]);
    }

    public function generatePdf()
    {
        return redirect()->route('report-pelanggan.generate', [
            'filterStartDate' => $this->filterStartDate,
            'filterEndDate' => $this->filterEndDate,
        ]);
    }

    public function render()
    {
        return view('livewire.report.pelanggan-report');
    }
}
