<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class WithdrawForm extends Form
{
    #[Validate(['nullable', 'min:2'])]
    public $ris;

    #[Validate(['nullable', 'min:2'])]
    public $requested_by;

    #[Validate(['nullable', 'min:2'])]
    public $approved_by;

    #[Validate(['nullable', 'min:2'])]
    public $issued_by;

    #[Validate(['nullable', 'min:2'])]
    public $received_by;

    #[Validate(['nullable', 'min:2'])]
    public $stock_id;
  
}
