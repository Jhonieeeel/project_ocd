<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class WithdrawForm extends Form
{
    #[Validate(['nullable', 'min:2'])]
    public $ris;

    #[Validate(['nullable', 'exists:users,id'])]
    public $requested_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $approved_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $issued_by;

    #[Validate(['nullable', 'exists:users,id'])]
    public $received_by;

    #[Validate('boolean')]
    public $status;

    #[Validate(['nullable', 'min:2'])]
    public $stock_id;

    #[Validate(['nullable', 'min:2'])]
    public $remarks;
}
