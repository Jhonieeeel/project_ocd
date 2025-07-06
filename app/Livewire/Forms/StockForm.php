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

    #[Validate(['required', 'integer'])]
    public $item_quantity;

    #[Validate(['required'])]
    public $remarks;

    #[Validate(['required'])]
    public $expiration; 

    #[Validate(['required'])]
    public $supply_id;
}
