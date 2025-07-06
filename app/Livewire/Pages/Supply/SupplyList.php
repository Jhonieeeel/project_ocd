<?php

namespace App\Livewire\Pages\Supply;

use Livewire\Attributes\Layout;
use Livewire\Component;

class SupplyList extends Component
{

    public function test(){
        logger("This is from supply list");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.supply.supply-list');
    }
}
