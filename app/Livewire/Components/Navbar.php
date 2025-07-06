<?php

namespace App\Livewire\Components;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class Navbar extends Component
{
    public function logout(Logout $logout) {
        $logout();

        return redirect("/login");
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
