<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TrxBarangKeluar;

class GroupTrxBarangKeluarTable extends Component
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
        return redirect()->route('trx-barang-keluar.by-date', ['tanggal' => $date]);
    }

    public function render()
    {
        $data = TrxBarangKeluar::query()
            ->join('barangs', 'trx_barang_keluars.id_barang', '=', 'barangs.id_barang')
            ->selectRaw("
                DATE(trx_barang_keluars.tanggal_keluar) as tanggal,
                SUM(trx_barang_keluars.jumlah_brgkeluar) as total_keluar,
                GROUP_CONCAT(DISTINCT barangs.nama_barang SEPARATOR ',') as barang_list
            ")
            ->when($this->search, fn($q) =>
                $q->whereRaw("DATE(trx_barang_keluars.tanggal_keluar) LIKE ?", ["%{$this->search}%"])
            )
            ->groupBy('tanggal')
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.group-trx-barang-keluar', compact('data'));
    }
}
