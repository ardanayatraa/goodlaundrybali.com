<?php

namespace App\Http\Livewire\Report;

use App\Models\Barang;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangReport extends Component
{
    public $filterType = 'daily', $filterDate, $filterYear, $filterMonth, $filterWeek, $filterStartDate, $filterEndDate;
    public $filterDescription;
    public $apply = false;

    protected $primaryKey = 'id_barang';

    public function applyFilter()
    {
        if ($this->filterType === 'monthly' && $this->filterMonth) {
            $this->filterStartDate = Carbon::createFromFormat('Y-m', $this->filterMonth)->startOfMonth()->toDateString();
            $this->filterEndDate = Carbon::createFromFormat('Y-m', $this->filterMonth)->endOfMonth()->toDateString();
        }

        if ($this->filterType === 'yearly' && $this->filterYear) {
            $this->filterStartDate = Carbon::createFromFormat('Y', $this->filterYear)->startOfYear()->toDateString();
            $this->filterEndDate = Carbon::createFromFormat('Y', $this->filterYear)->endOfYear()->toDateString();
        }

        if ($this->filterType === 'weekly' && $this->filterWeek) {
            $this->filterStartDate = Carbon::parse($this->filterWeek)->startOfWeek()->toDateString();
            $this->filterEndDate = Carbon::parse($this->filterWeek)->endOfWeek()->toDateString();
        }

        switch ($this->filterType) {
            case 'daily':
                $this->filterDescription = "Harian: " . ($this->filterDate ?? 'Tidak dipilih');
                break;
            case 'monthly':
                $this->filterDescription = "Bulanan: " . ($this->filterMonth ?? 'Tidak dipilih');
                break;
            case 'yearly':
                $this->filterDescription = "Tahunan: " . ($this->filterYear ?? 'Tidak dipilih');
                break;
            case 'weekly':
                $this->filterDescription = "Mingguan: " . ($this->filterWeek ?? 'Tidak dipilih');
                break;
            case 'range':
                $this->filterDescription = "Rentang Tanggal: " . ($this->filterStartDate ?? '-') . " s/d " . ($this->filterEndDate ?? '-');
                break;
            default:
                $this->filterDescription = "Tidak ada filter yang dipilih";
        }

        $this->emit('filterUpdated', [
            'filterType' => $this->filterType,
            'filterDate' => $this->filterDate,
            'filterYear' => $this->filterYear,
            'filterMonth' => $this->filterMonth,
            'filterWeek' => $this->filterWeek,
            'filterStartDate' => $this->filterStartDate,
            'filterEndDate' => $this->filterEndDate,
            'filterDescription' => $this->filterDescription,
        ]);

        $this->apply = true;
    }

    public function generatePdf()
    {
        $queryParams = [
            'filterType' => $this->filterType,
            'filterDate' => $this->filterDate,
            'filterYear' => $this->filterYear,
            'filterMonth' => $this->filterMonth,
            'filterWeek' => $this->filterWeek,
            'filterStartDate' => $this->filterStartDate,
            'filterEndDate' => $this->filterEndDate,
        ];

        return redirect()->route('report-barang.generate', $queryParams);
    }

    public function render()
    {
        $barang = Barang::all();
        return view('livewire.report.barang-report', ['barang' => $barang]);
    }
}
