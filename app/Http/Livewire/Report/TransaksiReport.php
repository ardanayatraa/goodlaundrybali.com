<?php

namespace App\Http\Livewire\Report;

use App\Models\Transaksi;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Updated import statement

class TransaksiReport extends Component
{
    public $filterType = 'daily', $filterDate, $filterYear, $filterMonth, $filterWeek, $filterStartDate, $filterEndDate;
    public $filterDescription; // Tambahkan properti untuk deskripsi filter
    public $apply=false;

    /**
     * Terapkan filter berdasarkan tipe filter yang dipilih.
     * Mengatur tanggal awal dan akhir berdasarkan filter yang dipilih.
     * Emit event 'filterUpdated' dengan parameter filter.
     */
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

        // Set filter description
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

        $this->apply=true;
    }

    /**
     * Mengarahkan pengguna ke rute untuk menghasilkan PDF berdasarkan parameter filter.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect()->route('report.generate', $queryParams);
    }

    /**
     * Render komponen Livewire dan mengirimkan data transaksi ke tampilan.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $transaksi = Transaksi::all();
        return view('livewire.report.transaksi-report',['transaksi'=>$transaksi]);
    }
}
