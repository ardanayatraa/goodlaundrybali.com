<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Paket;
use Carbon\Carbon;

class Add extends Component
{
    // — Pencarian Pelanggan —
    public $searchPelanggan = '';
    public $focusedPelanggan = false;
    public $id_pelanggan;

    // — Transaksi Utama —
    public $tanggal_transaksi;
    public $metode_pembayaran;
    public $status_pembayaran;
    public $status_transaksi = 'Diproses';
    public $keterangan;

    // — Pickup —
    public $samePickup = true;
    public $globalTanggalAmbil;
    public $globalJamAmbil;

    // — Poin & Diskon —
    public $jumlah_point   = 0;
    public $pointsToRedeem = 0;
    public $total_diskon   = 0;

    // — Total & Pembayaran —
    public $total_harga = 0;
    public $jumlah_bayar = 0;
    public $kembalian    = 0;

    // — Items Paket —
    public $items = [];

    protected function rules()
    {
        $rules = [
            'id_pelanggan'         => 'required|exists:pelanggans,id_pelanggan',
            'tanggal_transaksi'    => 'required|date',
            'items'                => 'required|array|min:1',
            'items.*.id_paket'     => 'required|exists:pakets,id_paket',
            'items.*.jumlah'       => 'required|integer|min:1',
            'metode_pembayaran'    => 'required|string',
            'status_pembayaran'    => 'required|string',
            'status_transaksi'     => 'required|string',
            'jumlah_bayar'         => 'required|numeric|min:0',
        ];

        if ($this->samePickup) {
            $rules['globalTanggalAmbil'] = 'required|date';
            $rules['globalJamAmbil']     = 'required|date_format:H:i';
        } else {
            $rules['items.*.tanggal_ambil'] = 'required|date';
            $rules['items.*.jam_ambil']     = 'required|date_format:H:i';
        }

        return $rules;
    }

    public function mount()
    {
        $this->globalTanggalAmbil = now()->format('Y-m-d');
        $this->globalJamAmbil     = now()->format('H:i');
        $this->tanggal_transaksi  = now()->format('Y-m-d');
        $this->addItem();
        $this->calculateTotalHarga();
    }

    public function updatedIdPelanggan()
    {
        $pel = Pelanggan::find($this->id_pelanggan);
        $this->jumlah_point   = $pel?->point ?? 0;
        $this->pointsToRedeem = $this->total_diskon = 0;
        $this->calculateTotalHarga();
    }

    public function updatedJumlahBayar($value)
    {
        $this->kembalian = max(0, $value - $this->total_harga);
    }

    public function updated($name, $value)
    {
        // react to items.*.id_paket / jumlah
        if (preg_match('/^items\.(\d+)\.(id_paket|jumlah)$/', $name, $m)) {
            [$all, $i, $field] = $m;
            $paket = Paket::find($this->items[$i]['id_paket']);
            $harga = $paket?->harga ?? 0;
            $jumlah = $this->items[$i]['jumlah'] ?? 1;
            $this->items[$i]['harga']    = $harga;
            $this->items[$i]['subtotal'] = $jumlah * $harga;
        }

        $this->calculateTotalHarga();
    }

    public function calculateTotalHarga()
    {
        $sum = array_sum(array_column($this->items, 'subtotal'));
        $this->total_harga = $sum - $this->total_diskon;
        $this->kembalian   = max(0, $this->jumlah_bayar - $this->total_harga);
    }

    public function usePoints()
    {
        if ($this->jumlah_point >= 10) {
            $this->pointsToRedeem = floor($this->jumlah_point / 10) * 10;
            $this->total_diskon   = ($this->pointsToRedeem / 10) * 100000; // misal 10 poin = Rp100.000
            $this->calculateTotalHarga();
            session()->flash('success', "Pakai {$this->pointsToRedeem} poin → diskon Rp " . number_format($this->total_diskon,0,',','.'));
        } else {
            session()->flash('error', 'Poin minimal 10.');
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'id_paket'      => null,
            'jumlah'        => 1,
            'harga'         => 0,
            'subtotal'      => 0,
            'tanggal_ambil' => null,
            'jam_ambil'     => null,
        ];
    }

    public function removeItem($idx)
    {
        unset($this->items[$idx]);
        $this->items = array_values($this->items);
        $this->calculateTotalHarga();
    }

    public function save()
    {
        $this->validate();

        \DB::beginTransaction();
        try {
            $trx = Transaksi::create([
                'id_pelanggan'      => $this->id_pelanggan,
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'total_harga'       => $this->total_harga,
                'metode_pembayaran' => $this->metode_pembayaran,
                'status_pembayaran' => $this->status_pembayaran,
                'status_transaksi'  => $this->status_transaksi,
                'keterangan'        => $this->keterangan,
                'jumlah_point'      => $this->jumlah_point,
                'jumlah_bayar'      => $this->jumlah_bayar,
                'kembalian'         => $this->kembalian,
            ]);

            foreach ($this->items as $row) {
                DetailTransaksi::create([
                    'id_transaksi'  => $trx->id_transaksi,
                    'id_paket'      => $row['id_paket'],
                    'tanggal_ambil' => $this->samePickup ? $this->globalTanggalAmbil : $row['tanggal_ambil'],
                    'jam_ambil'     => $this->samePickup ? $this->globalJamAmbil   : $row['jam_ambil'],
                    'jumlah'        => $row['jumlah'],
                    'sub_total'     => $row['subtotal'],
                    'total_diskon'  => 0,
                    'keterangan'    => $this->keterangan,
                ]);
            }

            // kurangi poin pelanggan
            if ($this->pointsToRedeem > 0) {
                $pel = Pelanggan::find($this->id_pelanggan);
                $pel->update(['point' => max(0, $pel->point - $this->pointsToRedeem)]);
            }

            \DB::commit();
            return redirect()->route('transaksi.detail', $trx->id_transaksi);
        } catch (\Throwable $e) {
            \DB::rollBack();
            session()->flash('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaksi.add', [
            'pelanggans' => Pelanggan::where('nama_pelanggan','like',"%{$this->searchPelanggan}%")->limit(5)->get(),
            'pakets'     => Paket::all(),
        ]);
    }
}
