<?php

namespace App\Http\Livewire\Admin;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Dashboard extends Component
{
    public $page = 'Dashboard';
    public $cards = [];

    public function mount()
    {
        $data = [];
        $statistics = Cache::remember('statistics', 60 * 15, function () {
            return [
                'UsersCount' => User::userRole()->count()
            ];
        });
        $data['Users'] = ['count' => $statistics['UsersCount'], 'route' => route('users'), 'class' => 'bg-primary', 'icon' => 'fas fa-solid fa-users'];
        $this->cards = $data;
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
