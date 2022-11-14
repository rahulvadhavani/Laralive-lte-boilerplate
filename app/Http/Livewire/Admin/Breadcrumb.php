<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Breadcrumb extends Component
{
    public $page;
    public function render()
    {
        return view('livewire.admin.breadcrumb');
    }
}
