<?php

namespace App\Livewire\Components;

use App\Models\Stock;
use App\Models\Supply;
use Livewire\Component;

class TotalCards extends Component
{
    public function render()
    {
        return view('livewire.components.total-cards', [
            "supplies" => Supply::count(),
            "stocks" => Stock::count()
        ]);
    }
}
