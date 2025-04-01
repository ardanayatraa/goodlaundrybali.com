<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Point;
use App\Models\Paket;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class Add extends Component
{
    public $id_pelanggan, $jumlah_point, $id_paket, $tanggal_transaksi, $total_harga, $metode_pembayaran, $status_pembayaran, $status_transaksi='Diproses';
    public $tanggal_ambil, $jam_ambil, $jumlah, $total_diskon=0, $keterangan;
    public $searchPelanggan = '', $searchPaket = '';
    public $focusedPelanggan = false, $focusedPaket = false;
    public $usePointCheckbox = false; // Tracks the state of the checkbox

    protected $rules = [
        'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
        'id_paket' => 'required|exists:pakets,id_paket',
        'tanggal_transaksi' => 'required|date',
        'total_harga' => 'required|numeric',
        'metode_pembayaran' => 'required|string|max:50',
        'status_pembayaran' => 'required|string|max:50',
        'status_transaksi' => 'required|string|max:50',
        'jumlah_point' => 'nullable|integer',
        'tanggal_ambil' => 'required|date',
        'jam_ambil' => 'required|date_format:H:i',
        'jumlah' => 'required|integer',
        'total_diskon' => 'nullable|numeric',
        'keterangan' => 'nullable|string|max:255',
    ];

    public function updatedIdPelanggan()
    {
        // Automatically fetch the latest jumlah_point for the selected pelanggan
        $this->jumlah_point = Point::where('id_pelanggan', $this->id_pelanggan)->latest('tanggal')->value('jumlah_point');
    }

    public function updatedIdPaket()
    {
        $this->calculateTotalHarga();
    }

    public function updatedJumlah()
    {
        $this->calculateTotalHarga();
    }

    public function updatedUsePointCheckbox()
    {
        if ($this->usePointCheckbox) {
            $this->applyPoints();
        } else {
            $this->total_diskon = 0; // Reset discount if checkbox is unchecked
            $this->calculateTotalHarga();
        }
    }

    private function applyPoints()
    {
        if ($this->jumlah_point >= 10) {
            $pointsToRedeem = floor($this->jumlah_point / 10) * 10; // Redeemable points in multiples of 10
            $discount = ($pointsToRedeem / 10) * 10000; // Calculate discount
            $this->total_diskon = $discount;
            $this->calculateTotalHarga();
        } else {
            $this->usePointCheckbox = false; // Uncheck the checkbox if points are insufficient
            session()->flash('error', 'Jumlah poin tidak mencukupi untuk mendapatkan diskon.');
        }
    }

    private function calculateTotalHarga()
    {
        if ($this->id_paket && $this->jumlah) {
            $paket = Paket::find($this->id_paket);
            if ($paket) {
                $this->total_harga = $this->jumlah * $paket->harga;

                // Apply discount if points are used
                if ($this->total_diskon) {
                    $this->total_harga -= $this->total_diskon;
                }
            } else {
                $this->total_harga = 0;
            }
        } else {
            $this->total_harga = 0;
        }
    }

    public function usePoints()
    {
        if ($this->jumlah_point >= 10) {
            $pointsToRedeem = floor($this->jumlah_point / 10) * 10; // Redeemable points in multiples of 10
            $discount = ($pointsToRedeem / 10) * 10000; // Calculate discount
            $this->total_diskon = $discount;

            // Deduct redeemed points from the database
            $pointRecord = Point::where('id_pelanggan', $this->id_pelanggan)->latest('tanggal')->first();
            if ($pointRecord) {
                $pointRecord->decrement('jumlah_point', $pointsToRedeem);
                $this->jumlah_point = $pointRecord->jumlah_point; // Update the local property with the new value
            }

            session()->flash('success', "Berhasil menggunakan $pointsToRedeem poin untuk potongan Rp $discount.");
        } else {
            session()->flash('error', 'Jumlah poin tidak mencukupi untuk mendapatkan diskon.');
        }

        // Recalculate total_harga after applying discount
        $this->calculateTotalHarga();
    }

    public function save()
    {
        $this->validate(); // Ensure all fields, including id_paket, are validated

        if (is_null($this->id_paket)) {
            session()->flash('error', 'Paket harus dipilih sebelum menyimpan transaksi.');
            return;
        }

        try {
            // Fetch the selected paket
            $paket = Paket::find($this->id_paket);

            if (!$paket) {
                session()->flash('error', 'Paket tidak ditemukan.');
                return;
            }

            // Calculate total_harga
            $this->total_harga = $this->jumlah * $paket->harga;

            // Apply discount if available
            if ($this->total_diskon) {
                $this->total_harga -= $this->total_diskon;
            }

            // Start a database transaction
            \DB::beginTransaction();

            // Create the Transaksi record
            $transaksi = Transaksi::create([
                'id_pelanggan' => $this->id_pelanggan,
                'id_paket' => $this->id_paket,
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'total_harga' => $this->total_harga,
                'metode_pembayaran' => $this->metode_pembayaran,
                'status_pembayaran' => $this->status_pembayaran,
                'status_transaksi' => $this->status_transaksi,
                'jumlah_point' => $this->jumlah_point,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);


            // Create the DetailTransaksi record
            $detailTransaksi = DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi, // Use the generated id from Transaksi
                'tanggal_ambil' => $this->tanggal_ambil,
                'jam_ambil' => $this->jam_ambil,
                'jumlah' => $this->jumlah,
                'total_diskon' => $this->total_diskon,
                'keterangan' => $this->keterangan,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Deduct points from the points table
            if ($this->usePointCheckbox && $this->jumlah_point >= 10) {
                $pointsToRedeem = floor($this->jumlah_point / 10) * 10; // Redeemable points in multiples of 10
                Point::where('id_pelanggan', $this->id_pelanggan)
                    ->latest('tanggal')
                    ->first()
                    ->decrement('jumlah_point', $pointsToRedeem);
            }

            // Commit the transaction
            \DB::commit();

            $this->reset();
            return redirect('/transaksi');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            \DB::rollBack();

            // Log the error for debugging
            \Log::error('Error saving transaction: ' . $e->getMessage(), [
                'id_pelanggan' => $this->id_pelanggan,
                'id_paket' => $this->id_paket,
                'tanggal_transaksi' => $this->tanggal_transaksi,
                'total_harga' => $this->total_harga,
                'metode_pembayaran' => $this->metode_pembayaran,
                'status_pembayaran' => $this->status_pembayaran,
                'status_transaksi' => $this->status_transaksi,
            ]);

            // Provide a detailed error message to the user
            session()->flash('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaksi.add', [
            'pelanggans' => Pelanggan::where('nama_pelanggan', 'like', '%' . $this->searchPelanggan . '%')->limit(5)->get(),
            'pakets' => Paket::where('jenis_paket', 'like', '%' . $this->searchPaket . '%')->limit(5)->get(),
            'canUsePoints' => $this->jumlah_point >= 10, // Pass whether points can be used to the view
        ]);
    }
}
