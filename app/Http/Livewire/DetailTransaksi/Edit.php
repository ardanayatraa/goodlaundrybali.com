<?php

namespace App\Http\Livewire\DetailTransaksi;

use Livewire\Component;
use App\Models\DetailTransaksi;

class Edit extends Component
{
    public $id_detail_transaksi, $id_transaksi, $id_paket, $jumlah, $subtotal;

    protected $rules = [
        'id_transaksi' => 'required|exists:transaksis,id_transaksi',
        'id_paket' => 'required|exists:pakets,id_paket',
        'jumlah' => 'required|integer|min:1',
        'subtotal' => 'required|numeric',
    ];

    /**
     * Menginisialisasi properti dengan data dari DetailTransaksi berdasarkan ID.
     *
     * @param int $id_detail_transaksi ID dari detail transaksi yang akan diedit.
     * @return void
     */
    public function mount($id_detail_transaksi)
    {
        $detail = DetailTransaksi::findOrFail($id_detail_transaksi);
        $this->id_detail_transaksi = $detail->id_detail_transaksi;
        $this->id_transaksi = $detail->id_transaksi;
        $this->id_paket = $detail->id_paket;
        $this->jumlah = $detail->jumlah;
        $this->subtotal = $detail->subtotal;
    }

    /**
     * Validasi dan perbarui data DetailTransaksi di database.
     * Setelah data diperbarui, pengguna akan diarahkan ke halaman detail transaksi.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->validate();

        DetailTransaksi::where('id_detail_transaksi', $this->id_detail_transaksi)->update([
            'id_transaksi' => $this->id_transaksi,
            'id_paket' => $this->id_paket,
            'jumlah' => $this->jumlah,
            'subtotal' => $this->subtotal,
        ]);

        return redirect('/detail-transaksi');
    }

    /**
     * Render tampilan komponen Livewire untuk mengedit detail transaksi.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.detail-transaksi.edit');
    }
}
