<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;

class Delete extends Component
{
    public $showModal = false;
    public $id_admin;

    public function mount($id_admin)
    {
        $this->id_admin = $id_admin;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        Admin::where('id_admin', $this->id_admin)->delete();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.admin.delete');
    }
}
