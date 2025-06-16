<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TrxBarangMasuk;

class GroupTrxBarangMasukTable extends Component
{
    use WithPagination;

    public $search    = '';
    public $perPage   = 10;
    public $sortField = 'tanggal';
    public $sortAsc   = true;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortField = $field;
            $this->sortAsc   = true;
        }
        $this->resetPage();
    }

    public function viewByDate($date)
    {
        return redirect()->route('trx-barang-masuk.by-date', ['tanggal' => $date]);
    }

    public function render()
    {
        $data = TrxBarangMasuk::query()
            ->join('barangs', 'trx_barang_masuks.id_barang', '=', 'barangs.id_barang')
            ->selectRaw("
                DATE(trx_barang_masuks.tanggal_masuk) as tanggal,
                SUM(trx_barang_masuks.total_harga) as total_harga,
                GROUP_CONCAT(DISTINCT barangs.nama_barang SEPARATOR ',') as barang_list
            ")
            ->when($this->search, fn($q) =>
                $q->whereRaw("DATE(trx_barang_masuks.tanggal_masuk) LIKE ?", ["%{$this->search}%"])
            )
            ->groupBy('tanggal')
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.group-trx-barang-masuk', compact('data'));
    }
}
