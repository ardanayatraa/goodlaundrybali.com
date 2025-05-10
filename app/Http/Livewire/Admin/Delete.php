<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;

class Delete extends Component
{
    public $showModal = false;
    public $id_admin;

    /**
     * Inisialisasi komponen dengan ID admin.
     *
     * @param int $id_admin ID admin yang akan dihapus.
     */
    public function mount($id_admin)
    {
        $this->id_admin = $id_admin;
    }

    /**
     * Membuka modal konfirmasi penghapusan.
     *
     * @return void
     */
    public function openModal()
    {
        $this->showModal = true;
    }

    /**
     * Menghapus data admin berdasarkan ID dan menutup modal.
     *
     * @return void
     */
    public function delete()
    {
        Admin::where('id_admin', $this->id_admin)->delete();
        $this->showModal = false;
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.delete');
    }
}
