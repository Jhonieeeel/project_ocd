<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SupplyForm extends Form
{
    #[Validate(['required', 'min:2'])]
    public $item_description;

    #[Validate('required')]
    public $category;

    #[Validate('required')]
    public $unit;

    #[Validate('nullable', 'image')]
    public $image;
}
