<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\WithdrawForm;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class MyRequestTable extends Component
{
    use WithPagination;

    public WithdrawForm $withdrawForm;

    public $requested_quantity;

    public Withdraw $selectedEdit;

    public $user_id;
    public $stock_id;

    public function selectEdit(Withdraw $withdraw)
    {
        $this->selectedEdit = $withdraw;
        $this->user_id = $withdraw->user_id;
        $this->stock_id = $withdraw->stock_id;
        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $max_quantity = $this->selectedEdit->stock->item_quantity;
        $validate = $this->validate([
            'requested_quantity' => ['required', 'integer', 'min:1', 'max:' . $max_quantity]
        ]);
        $this->selectedEdit->requested_quantity = $validate['requested_quantity'];

        $this->selectedEdit->save();
    }

    public function mount()
    {
        $this->selectedEdit = Withdraw::first() ?? new Withdraw();
    }

    #[Computed]
    public function requests()
    {
        return Withdraw::where('user_id', auth()->id())->paginate(5);
    }

    public function render()
    {
        return view('livewire.components.my-request-table');
    }
}
