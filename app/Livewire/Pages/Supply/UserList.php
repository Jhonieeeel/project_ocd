<?php

namespace App\Livewire\Pages\Supply;

use Livewire\Attributes\Layout;
use Livewire\Component;

class UserList extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.supply.user-list');
    }
}
