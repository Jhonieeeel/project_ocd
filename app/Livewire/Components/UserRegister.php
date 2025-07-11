<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class UserRegister extends Component
{
    public UserForm $userForm;
    public $userRole;
    public $userDivison;
    public $userOffice;

    public function save()
    {
        $validated = $this->userForm->validate();
        if ($validated) {
            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);
            $user->assignRole($this->userRole);
            $this->dispatch('refresh');
        } else {
            dd($validated);
        }
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.user-register', [
            'roles' => ['super-admin', 'admin', 'issueance', 'user'],
            'divisions' => ['ORD', 'AFMS'],
            'offices' => ['GASU', 'PMU', 'FMU', 'HRMU', 'RMU'],
        ]);
    }
}
