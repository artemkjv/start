<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Page;
use Illuminate\Support\Collection;

class EditComponent extends Component
{

    public Collection $pages;
    public Collection $users;
    public array $state = [];
    public User $user;

    public function mount(User $user) {
        $this->user = $user;
        $this->pages = Page::getByUser(\request()->user());
        $this->users = User::getByUser(\request()->user());
        $this->state['role'] = $user->role;
        $this->state['all_users'] = $user->all_users;
        $this->state['pages'] = Page::getByUser($user)->pluck('id')
            ->toArray();
        $this->state['users'] = User::getByUser($user)->pluck('id')
            ->toArray();
    }

    public function updatedState(){
        $this->emit('updatedState', $this->state);
    }

    public function render()
    {
        return view('livewire.user.edit-component');
    }
}
