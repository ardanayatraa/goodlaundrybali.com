<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;

class FilterData extends Component
{
    public $filterTanggal    = '';
    public $filterPembayaran = '';
    public $filterTransaksi  = '';

    protected $queryString = [
        'filterTanggal'    => ['except' => '', 'as' => 'tanggal'],
        'filterPembayaran' => ['except' => '', 'as' => 'status-pembayaran'],
        'filterTransaksi'  => ['except' => '', 'as' => 'status-transaksi'],
    ];

    public function render()
    {
        return view('livewire.transaksi.filter-data');
    }
}
