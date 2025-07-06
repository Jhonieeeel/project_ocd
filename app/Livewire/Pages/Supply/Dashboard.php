<?php

namespace App\Livewire\Pages\Supply;

use App\Models\Stock;
use App\Models\Supply;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.supply.dashboard', [
            'supplies' => Supply::count(),
            'stocks' => Stock::count(),
        ]);
    }
}
