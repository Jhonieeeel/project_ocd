<?php

namespace App\Livewire\Pages\Supply;

use Livewire\Attributes\Layout;
use Livewire\Component;

class RequestList extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.supply.request-list');
    }
}
