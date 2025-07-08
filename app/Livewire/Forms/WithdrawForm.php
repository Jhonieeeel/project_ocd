<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class WithdrawForm extends Form
{

    #[Validate(['nullable', 'min:2'])]
    public $ris;

    #[Validate(['nullable', 'min:2'])]
    public $remarks;

    #[Validate(['nullable', 'exists:users,id'])]
    public $requested_by;

    #[Validate(['nullable', 'date_format:Y-m-d'])]
    public $requested_date;

    #[Validate(['nullable', 'exists:users,id'])]
    public $approved_by;

    #[Validate(['nullable', 'date_format:Y-m-d'])]
    public $approved_date;

    #[Validate(['nullable', 'exists:users,id'])]
    public $issued_by;

    #[Validate(['nullable', 'date_format:Y-m-d'])]
    public $issued_date;

    #[Validate(['nullable', 'exists:users,id'])]
    public $received_by;

    #[Validate(['nullable', 'date_format:Y-m-d'])]
    public $received_date;

    #[Validate(['nullable', 'exists:stocks,id'])]
    public $stock_id;

    #[Validate(['required', 'integer', 'min:1'])]
    public $requested_quantity;

    #[Validate('boolean')]
    public bool $status;
}
