<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransaksiReport extends Component
{
    public $filterType = 'harian';
    public $startDate, $endDate;

    public function mount()
    {
        $this->setDateRange();
    }

    public function setDateRange()
    {
        $now = Carbon::now();

        if ($this->filterType === 'harian') {
            $this->startDate = $now->toDateString();
            $this->endDate = null; // No end date for "Harian"
        } elseif ($this->filterType === 'mingguan') {
            $this->startDate = $now->startOfWeek()->toDateString();
            $this->endDate = $now->endOfWeek()->toDateString();
        } elseif ($this->filterType === 'bulanan') {
            $this->startDate = $now->startOfMonth()->toDateString();
            $this->endDate = $now->endOfMonth()->toDateString();
        }
    }

    public function updatedFilterType()
    {
        $this->setDateRange();
    }

    public function render()
    {
        $query = Transaksi::query();

        if ($this->filterType === 'harian') {
            $query->whereDate('tanggal_transaksi', $this->startDate); // Single date for "Harian"
        } else {
            $query->whereBetween('tanggal_transaksi', [$this->startDate, $this->endDate]);
        }

        $transaksi = $query->where('status_pembayaran', 'Lunas') // Only "Lunas" transactions
            ->with(['pelanggan', 'paket', 'detailTransaksi'])
            ->get();

        // Group transactions by customer
        $groupedTransaksi = $transaksi->groupBy('id_pelanggan')->map(function ($group) {
            return [
                'pelanggan' => $group->first()->pelanggan->nama ?? 'Unknown',
                'transactions' => $group,
                'subtotal' => $group->sum('total_harga'),
            ];
        });

        // Calculate grand total
        $grandTotal = $groupedTransaksi->sum('subtotal');

        return view('livewire.report.transaksi-report', compact('groupedTransaksi', 'grandTotal'));
    }

    public function downloadPDF()
    {
        $query = Transaksi::query();

        if ($this->filterType === 'harian') {
            $query->whereDate('tanggal_transaksi', $this->startDate);
        } else {
            $query->whereBetween('tanggal_transaksi', [$this->startDate, $this->endDate]);
        }

        $transaksi = $query->where('status_pembayaran', 'Lunas')
            ->with(['pelanggan', 'paket', 'detailTransaksi'])
            ->get();

        $groupedTransaksi = $transaksi->groupBy('id_pelanggan')->map(function ($group) {
            return [
                'pelanggan' => $group->first()->pelanggan->nama ?? 'Unknown',
                'transactions' => $group,
                'subtotal' => $group->sum('total_harga'),
            ];
        });

        $grandTotal = $groupedTransaksi->sum('subtotal');

        $pdf = Pdf::loadView('exports.transaksi-pdf', compact('groupedTransaksi', 'grandTotal'))->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Laporan_Transaksi_' . now()->format('YmdHis') . '.pdf'
        );
    }
}
