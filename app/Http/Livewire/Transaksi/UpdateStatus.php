<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class UpdateStatus extends Component
{
    public $id_transaksi, $status_transaksi;

    protected $listeners = ['editStatus' => 'loadStatus'];

    /**
     * Memuat status transaksi berdasarkan id_transaksi.
     *
     * @param int $id
     */
    public function loadStatus($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $this->id_transaksi = $transaksi->id_transaksi;
        $this->status_transaksi = $transaksi->status_transaksi;
    }

    /**
     * Memperbarui status transaksi ketika status_transaksi diperbarui.
     */
    public function updatedStatusTransaksi()
    {
        if ($this->id_transaksi) {
            $transaksi = Transaksi::findOrFail($this->id_transaksi);
            $transaksi->update(['status_transaksi' => $this->status_transaksi]);

            $this->emit('refreshLivewireDatatable');
            $this->dispatchBrowserEvent('close-modal');
        }
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.transaksi.update-status');
    }
}
