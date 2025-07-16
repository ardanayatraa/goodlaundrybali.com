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
    public $keterangan = '';

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
            'id_pelanggan'       => 'required|exists:pelanggans,id_pelanggan',
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
        // Inisialisasi default dengan safety check
        $this->tanggal_transaksi = now()->format('Y-m-d');
        $this->globalTanggalAmbil = now()->format('Y-m-d');
        $this->globalJamAmbil     = now()->format('H:i');
        $this->jumlah_bayar       = 0;
        $this->kembalian          = 0;
        $this->jumlah_point       = 0;
        $this->pointsToRedeem     = 0;
        $this->total_diskon       = 0;
        $this->total_harga        = 0;

        $this->addItem();
        $this->calculateTotalHarga();
    }

    public function updatedIdPelanggan()
    {
        if ($this->id_pelanggan) {
            $pel = Pelanggan::find($this->id_pelanggan);
            $this->jumlah_point = $pel?->point ?? 0;
        } else {
            $this->jumlah_point = 0;
        }

        $this->pointsToRedeem = 0;
        $this->total_diskon = 0;
        $this->calculateTotalHarga();
    }

    public function updatedJumlahBayar($value)
    {
        $bayar = (float) $value;
        $bayar = max(0, $bayar); // Pastikan tidak negatif
        $this->kembalian = max(0, $bayar - $this->total_harga);
    }

    public function updated($name, $value)
    {
        // Kalkulasi harga item jika paket atau jumlah berubah
        if (preg_match('/^items\.(\d+)\.(id_paket|jumlah)$/', $name, $m)) {
            [$all, $i, $field] = $m;

            // Safety check untuk index
            if (!isset($this->items[$i])) {
                return;
            }

            $paket = null;
            if (!empty($this->items[$i]['id_paket'])) {
                $paket = Paket::find($this->items[$i]['id_paket']);
            }

            $harga = $paket?->harga ?? 0;
            $jumlah = max(1, (int) ($this->items[$i]['jumlah'] ?? 1)); // Minimal 1

            $this->items[$i]['harga']    = $harga;
            $this->items[$i]['subtotal'] = $harga * $jumlah;
            $this->items[$i]['jumlah']   = $jumlah; // Update jumlah jika kurang dari 1
        }

        $this->calculateTotalHarga();
    }

    public function calculateTotalHarga()
    {
        $sum = 0;

        // Safety check untuk items
        if (is_array($this->items)) {
            foreach ($this->items as $item) {
                $subtotal = (float) ($item['subtotal'] ?? 0);
                $sum += max(0, $subtotal); // Pastikan subtotal tidak negatif
            }
        }

        $diskon = max(0, (float) $this->total_diskon);
        $this->total_harga = max(0, $sum - $diskon);

        $bayar = max(0, (float) $this->jumlah_bayar);
        $this->kembalian = max(0, $bayar - $this->total_harga);
    }

    public function usePoints()
    {
        $availablePoints = max(0, (int) $this->jumlah_point);

        if ($availablePoints >= 10) {
            $this->pointsToRedeem = floor($availablePoints / 10) * 10;
            $this->total_diskon   = ($this->pointsToRedeem / 10) * 10000; // 10 poin = 10k
            $this->calculateTotalHarga();

            $formatDiskon = number_format($this->total_diskon, 0, ',', '.');
            session()->flash('success', "Pakai {$this->pointsToRedeem} poin → diskon Rp {$formatDiskon}");
        } else {
            session()->flash('error', 'Poin minimal 10 untuk dapat diskon.');
        }
    }

    public function resetPoints()
    {
        $this->pointsToRedeem = 0;
        $this->total_diskon = 0;
        $this->calculateTotalHarga();
        session()->flash('info', 'Poin dikembalikan.');
    }

    public function addItem()
    {
        $this->items[] = [
            'id_paket'      => null,
            'jumlah'        => 1,
            'harga'         => 0,
            'subtotal'      => 0,
            'tanggal_ambil' => $this->samePickup ? null : now()->format('Y-m-d'),
            'jam_ambil'     => $this->samePickup ? null : now()->format('H:i'),
        ];
    }

    public function removeItem($idx)
    {
        if (isset($this->items[$idx])) {
            unset($this->items[$idx]);
            $this->items = array_values($this->items);
            $this->calculateTotalHarga();
        }
    }

    public function updatedSamePickup()
    {
        if ($this->samePickup) {
            // Reset individual pickup times
            foreach ($this->items as $i => $item) {
                $this->items[$i]['tanggal_ambil'] = null;
                $this->items[$i]['jam_ambil'] = null;
            }
        } else {
            // Set individual pickup times
            foreach ($this->items as $i => $item) {
                if (empty($this->items[$i]['tanggal_ambil'])) {
                    $this->items[$i]['tanggal_ambil'] = now()->format('Y-m-d');
                }
                if (empty($this->items[$i]['jam_ambil'])) {
                    $this->items[$i]['jam_ambil'] = now()->format('H:i');
                }
            }
        }
    }

    public function save()
    {
        $this->validate();

        // Additional safety checks
        if (empty($this->items)) {
            session()->flash('error', 'Minimal harus ada 1 item.');
            return;
        }

        if ($this->total_harga <= 0) {
            session()->flash('error', 'Total harga harus lebih dari 0.');
            return;
        }

        \DB::beginTransaction();
        try {
            // Create main transaction
            $trx = Transaksi::create([
                'id_pelanggan'      => $this->id_pelanggan,
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'total_harga'       => max(0, $this->total_harga),
                'metode_pembayaran' => $this->metode_pembayaran,
                'status_pembayaran' => $this->status_pembayaran,
                'status_transaksi'  => $this->status_transaksi,
                'keterangan'        => $this->keterangan ?? '',
                'jumlah_point'      => max(0, $this->jumlah_point),
                'jumlah_bayar'      => max(0, $this->jumlah_bayar),
                'kembalian'         => max(0, $this->kembalian),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);

            // Create detail transactions
            foreach ($this->items as $row) {
                if (empty($row['id_paket'])) {
                    continue; // Skip empty items
                }

                DetailTransaksi::create([
                    'id_transaksi'  => $trx->id_transaksi,
                    'id_paket'      => $row['id_paket'],
                    'tanggal_ambil' => $this->samePickup ? $this->globalTanggalAmbil : ($row['tanggal_ambil'] ?? now()->format('Y-m-d')),
                    'jam_ambil'     => $this->samePickup ? $this->globalJamAmbil : ($row['jam_ambil'] ?? now()->format('H:i')),
                    'jumlah'        => max(1, (int) ($row['jumlah'] ?? 1)),
                    'sub_total'     => max(0, (float) ($row['subtotal'] ?? 0)),
                    'total_diskon'  => 0,
                    'keterangan'    => $this->keterangan ?? '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }

            // Update customer points
            if ($this->pointsToRedeem > 0) {
                $pel = Pelanggan::find($this->id_pelanggan);
                if ($pel) {
                    $newPoints = max(0, $pel->point - $this->pointsToRedeem);
                    $pel->update(['point' => $newPoints]);
                }
            }

            \DB::commit();
            session()->flash('success', 'Transaksi berhasil disimpan!');
            return redirect()->route('transaksi.detail', $trx->id_transaksi);

        } catch (\Throwable $e) {
            \DB::rollBack();
            session()->flash('error', 'Gagal simpan transaksi: ' . $e->getMessage());
            \Log::error('Transaction save error: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'searchPelanggan',
            'id_pelanggan',
            'metode_pembayaran',
            'status_pembayaran',
            'keterangan',
            'pointsToRedeem',
            'total_diskon',
            'jumlah_bayar',
            'items'
        ]);

        $this->mount();
    }

    public function render()
    {
        $pelanggans = collect();
        $pakets = collect();

        // Safe query for customers
        if (strlen($this->searchPelanggan) > 0) {
            $pelanggans = Pelanggan::where('nama_pelanggan', 'like', "%{$this->searchPelanggan}%")
                                  ->limit(5)
                                  ->get();
        }

        // Safe query for packages
        $pakets = Paket::where('status', 'aktif')
                      ->orderBy('nama_paket')
                      ->get();

        return view('livewire.transaksi.add', [
            'pelanggans' => $pelanggans,
            'pakets'     => $pakets,
        ]);
    }
}
