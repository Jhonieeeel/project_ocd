<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UserTable extends Component
{
    #[Computed()]
    public function users()
    {
        // the main super user
        return User::where('id', '!=', 1)->paginate(5);
    }

    public function superRole($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('super-admin')) {
            $user->removeRole('super-admin');
        } else {
            $user->assignRole('super-admin');
        }
    }

    public function adminRole($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('admin')) {
            $user->removeRole('admin');
        } else {
            $user->assignRole('admin');
        }
    }

    public function userRole($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('user')) {
            $user->removeRole('user');
        } else {
            $user->assignRole('user');
        }
    }


    public function render()
    {
        return view('livewire.components.user-table');
    }
}
