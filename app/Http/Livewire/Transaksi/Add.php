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
    public $no_telp;

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
    public $total_harga   = 0;
    public $jumlah_bayar  = 0;
    public $kembalian     = 0;

    // — Items Paket —
    public $items = [];

    protected function rules()
    {
        $rules = [
            'no_telp'            => 'required|exists:pelanggans,no_telp',
            'tanggal_transaksi'  => 'required|date',
            'items'              => 'required|array|min:1',
            'items.*.id_paket'   => 'required|exists:pakets,id_paket',
            'items.*.jumlah'     => 'required|integer|min:1',
            'metode_pembayaran'  => 'required|string',
            'status_pembayaran'  => 'required|string',
            'status_transaksi'   => 'required|string',
            'jumlah_bayar'       => 'required|numeric|min:0',
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
        // Inisialisasi default
        $this->tanggal_transaksi = now()->format('Y-m-d');
        $this->globalTanggalAmbil = now()->format('Y-m-d');
        $this->globalJamAmbil     = now()->format('H:i');
        $this->jumlah_bayar       = 0;
        $this->kembalian          = 0;

        $this->addItem();
        $this->calculateTotalHarga();
    }

    public function updatedNoTelp()
    {
        if ($this->no_telp) {
            $pel = Pelanggan::where('no_telp', $this->no_telp)->first();
            $this->jumlah_point = $pel?->point ?? 0;
            $this->pointsToRedeem = $this->total_diskon = 0;
            $this->focusedPelanggan = false;
            $this->searchPelanggan = '';
            $this->calculateTotalHarga();
        }
    }

    public function updatedJumlahBayar($value)
    {
        $bayar = (float) ($value ?? 0);
        $this->kembalian = max(0, $bayar - $this->total_harga);
    }

    public function updated($name, $value)
    {
        // Kalkulasi harga item jika paket atau jumlah berubah
        if (preg_match('/^items\.(\d+)\.(id_paket|jumlah)$/', $name, $m)) {
            [$all, $i, $field] = $m;
            $paket = Paket::find($this->items[$i]['id_paket']);
            $harga = (float) ($paket?->harga ?? 0);
            $jumlah = max(1, (int) ($this->items[$i]['jumlah'] ?? 1)); // Fix: ensure minimum 1

            $this->items[$i]['jumlah'] = $jumlah; // Fix: assign back to array
            $this->items[$i]['harga']    = $harga;
            $this->items[$i]['subtotal'] = $harga * $jumlah;
        }

        $this->calculateTotalHarga();
    }

    public function calculateTotalHarga()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $subtotal = (float) ($item['subtotal'] ?? 0);
            $sum += $subtotal;
        }

        $diskon = (float) ($this->total_diskon ?? 0);
        $bayar = (float) ($this->jumlah_bayar ?? 0);

        $this->total_harga = max(0, $sum - $diskon);
        $this->kembalian   = max(0, $bayar - $this->total_harga);
    }

    public function usePoints()
    {
        if ($this->jumlah_point >= 10) {
            $this->pointsToRedeem = floor($this->jumlah_point / 10) * 10;
            $this->total_diskon   = ($this->pointsToRedeem / 10) * 10000; // contoh: 10 poin = 100k
            $this->calculateTotalHarga();
            session()->flash('success', "Pakai {$this->pointsToRedeem} poin → diskon Rp " . number_format($this->total_diskon,0,',','.'));
        } else {
            session()->flash('error', 'Poin minimal 10.');
        }
    }

    // Fix: Method untuk select pelanggan
    public function selectPelanggan($no_telp)
    {
        $this->no_telp = $no_telp;
        $this->focusedPelanggan = false;
        $this->searchPelanggan = '';
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
                'no_telp'           => $this->no_telp,
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'total_harga'       => $this->total_harga,
                'metode_pembayaran' => $this->metode_pembayaran,
                'status_pembayaran' => $this->status_pembayaran,
                'status_transaksi'  => $this->status_transaksi,
                'keterangan'        => $this->keterangan,
                'jumlah_point'      => $this->jumlah_point,
                'jumlah_bayar'      => $this->jumlah_bayar,
                'kembalian'         => $this->kembalian,
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
                    'total_diskon'  => ($this->total_diskon / count($this->items)), // Fix: distribute discount
                    'keterangan'    => $this->keterangan,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }

            // Kurangi poin
            if ($this->pointsToRedeem > 0) {
                $pel = Pelanggan::where('no_telp', $this->no_telp)->first();
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
        // Fix: Get selected pelanggan data
        $selectedPelanggan = $this->no_telp ? Pelanggan::where('no_telp', $this->no_telp)->first() : null;

        // Jika sedang focus dan belum ada search, tampilkan 5 rekomendasi teratas
        if ($this->focusedPelanggan && empty($this->searchPelanggan)) {
            $pelanggans = Pelanggan::orderBy('created_at', 'desc')->limit(5)->get();
        } else {
            // Jika ada search, cari berdasarkan nama atau no_telp
            $pelanggans = Pelanggan::where(function($query) {
                            $query->where('nama_pelanggan','like',"%{$this->searchPelanggan}%")
                                  ->orWhere('no_telp','like',"%{$this->searchPelanggan}%");
                        })->limit(5)->get();
        }

        return view('livewire.transaksi.add', [
            'pelanggans' => $pelanggans,
            'selectedPelanggan' => $selectedPelanggan,
            'pakets'     => Paket::all(),
        ]);
    }
}
