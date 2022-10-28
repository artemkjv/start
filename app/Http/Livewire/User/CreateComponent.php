<?php

namespace App\Http\Livewire\User;

use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class CreateComponent extends Component
{

    public Collection $pages;
    public Collection $users;
    public array $state = [
        'role' => null,
        'all_users' => false
    ];

    public function render()
    {
        return view('livewire.user.create-component');
    }

    public function mount() {
        $this->pages = Page::getByUser(\request()->user());
        $this->users = User::getByUser(\request()->user());
    }

    public function updatedState(){
        $this->emit('updatedState', $this->state);
    }

}
