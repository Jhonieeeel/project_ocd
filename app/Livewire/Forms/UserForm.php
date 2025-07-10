<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public $name;

    #[Validate(['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class])]
    public $email;

    #[Validate(['required', 'string', 'confirmed', 'min:6', 'max:12'])]
    public $password;

    public $password_confirmation;

    // $validated['password'] = Hash::make($validated['password']);
}
