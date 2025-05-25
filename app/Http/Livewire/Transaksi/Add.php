<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Point;
use App\Models\Paket;
use Carbon\Carbon;

class Add extends Component
{
    // pencarian pelanggan
    public $searchPelanggan = '';
    public $focusedPelanggan = false;
    public $id_pelanggan;

    // transaksi & pembayaran
    public $tanggal_transaksi;
    public $metode_pembayaran;
    public $status_pembayaran;
    public $status_transaksi = 'Diproses';
    public $keterangan;

    // pickup global / per-item
    public $samePickup = true;
    public $globalTanggalAmbil;
    public $globalJamAmbil;

    // poin & diskon
    public $jumlah_point   = 0;
    public $pointsToRedeem = 0;
    public $total_diskon   = 0;

    // total harga
    public $total_harga = 0;

    // items paket
    public $items = [];

    protected $rules = [
        'id_pelanggan'         => 'required|exists:pelanggans,id_pelanggan',
        'tanggal_transaksi'    => 'required|date',
        'metode_pembayaran'    => 'required|string',
        'status_pembayaran'    => 'required|string',
        'status_transaksi'     => 'required|string',
        'items'                => 'required|array|min:1',
        'items.*.id_paket'     => 'required|exists:pakets,id_paket',
        'items.*.jumlah'       => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->globalTanggalAmbil = now()->format('Y-m-d');
        $this->globalJamAmbil     = now()->format('H:i');
        $this->addItem();
    }

    public function updatedIdPelanggan()
    {
      $this->jumlah_point = Pelanggan::find($this->id_pelanggan)?->point ?? 0;
        $this->pointsToRedeem = $this->total_diskon = 0;
        $this->calculateTotalHarga();
    }

    public function updated($name, $value)
    {
        if (preg_match('/^items\.(\d+)\.(\w+)$/', $name, $m)) {
            [$all, $i, $field] = $m;
            if ($field === 'id_paket') {
                $paket = Paket::find($value);
                $this->items[$i]['harga'] = $paket?->harga ?? 0;
            }
            $j = $this->items[$i]['jumlah']  ?? 1;
            $h = $this->items[$i]['harga']   ?? 0;
            $this->items[$i]['subtotal'] = $j * $h;
            $this->calculateTotalHarga();
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

    private function calculateTotalHarga()
    {
        $sum = array_sum(array_column($this->items, 'subtotal'));
        $this->total_harga = $sum - $this->total_diskon;
    }

    public function usePoints()
    {
        if ($this->jumlah_point >= 10) {
            $this->pointsToRedeem = floor($this->jumlah_point / 10) * 10;
            $this->total_diskon   = ($this->pointsToRedeem / 10) * 10000;
            $this->calculateTotalHarga();
            session()->flash('success', "Pakai {$this->pointsToRedeem} poin → diskon Rp " . number_format($this->total_diskon,0,',','.'));
        } else {
            session()->flash('error', 'Poin minimal 10.');
        }
    }

    public function save()
    {
        $this->items = array_values(array_filter($this->items, fn($r) => !is_null($r['id_paket'])));

        $rules = $this->rules;
        if ($this->samePickup) {
            $rules['globalTanggalAmbil'] = 'required|date';
            $rules['globalJamAmbil']     = 'required|date_format:H:i';
        } else {
            $rules['items.*.tanggal_ambil'] = 'required|date';
            $rules['items.*.jam_ambil']     = 'required|date_format:H:i';
        }
        $this->validate($rules);

        \DB::beginTransaction();
        try {
            $trx = Transaksi::create([
                'id_pelanggan'      => $this->id_pelanggan,
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'total_harga'       => $this->total_harga,
                'metode_pembayaran' => $this->metode_pembayaran,
                'status_pembayaran' => $this->status_pembayaran,
                'status_transaksi'  => $this->status_transaksi,
                'keterangan'  => $this->keterangan,
                'jumlah_point'      => $this->jumlah_point,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
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
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }

           if ($this->pointsToRedeem > 0) {

                $pelanggan = Pelanggan::find($this->id_pelanggan);
                if ($pelanggan) {
                    $pelanggan->point = max(0, $pelanggan->point - $this->pointsToRedeem);
                    $pelanggan->save();
                }
            }


            \DB::commit();
            return redirect()->route('transaksi');
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
