<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;

class Add extends Component
{
    public $showModal = false;
    public $nama_admin, $username, $password;

    /**
     * Membuka modal untuk menambahkan admin baru.
     *
     * @return void
     */
    public function openModal()
    {
        $this->showModal = true;
    }

    /**
     * Menyimpan data admin baru ke dalam database.
     *
     * @return void
     */
    public function save()
    {
        $this->validate([
            'nama_admin' => 'required|string|max:15',
            'username' => 'required|string|max:15|unique:admins,username',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'nama_admin' => $this->nama_admin,
            'username' => $this->username,
            'password' => bcrypt($this->password),
        ]);

        $this->reset();
        $this->showModal = false;
    }

    /**
     * Merender tampilan Livewire untuk menambahkan admin.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.add');
    }
}
