<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;

class Edit extends Component
{
    public $showModal = false;
    public $id_admin, $nama_admin, $username;

    /**
     * Fungsi untuk menginisialisasi data admin berdasarkan ID.
     *
     * @param int $id_admin ID admin yang akan di-edit.
     */
    public function mount($id_admin)
    {
        $admin = Admin::findOrFail($id_admin);
        $this->id_admin = $admin->id_admin;
        $this->nama_admin = $admin->nama_admin;
        $this->username = $admin->username;
    }

    /**
     * Fungsi untuk membuka modal.
     */
    public function openModal()
    {
        $this->showModal = true;
    }

    /**
     * Fungsi untuk memperbarui data admin.
     *
     * @return void
     */
    public function update()
    {
        $this->validate([
            'nama_admin' => 'required|string|max:15',
            'username' => 'required|string|max:15|unique:admins,username,' . $this->id_admin . ',id_admin',
        ]);

        Admin::where('id_admin', $this->id_admin)->update([
            'nama_admin' => $this->nama_admin,
            'username' => $this->username,
        ]);

        $this->showModal = false;
    }

    /**
     * Fungsi untuk merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.edit');
    }
}
