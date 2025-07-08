<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class StockForm extends Form
{
    #[Validate(['required', 'min:2'])]
    public $barcode;

    #[Validate(['required', 'decimal:0,2'])]
    public $item_price;

    #[Validate(['required', 'integer', 'min:1'])]
    public $item_quantity;

    #[Validate(['required', 'min:1'])]
    public $remarks;

    #[Validate(['required', 'min:1'])]
    public $expiration;

    #[Validate(['required', 'exists:supplies,id'])]
    public $supply_id;
}
