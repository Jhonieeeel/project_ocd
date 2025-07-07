<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\StockForm;
use App\Livewire\Forms\WithdrawForm;
use App\Models\Stock;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;

class StockTable extends Component
{

    public $requested_quantity;
    public $max_quantity;
    public $stock_id;
    public $user_id;

    public StockForm $stockForm;
    public WithdrawForm $withdrawForm;
    public Stock $selectedStock;

    public function selectEditStock(Stock $stock)
    {
        $this->stockForm->barcode = $stock->barcode;
        $this->stockForm->item_price = $stock->item_price;
        $this->stockForm->item_quantity = $stock->item_quantity;
        $this->stockForm->remarks = $stock->remarks;
        $this->stockForm->expiration = $stock->expiration;
        $this->dispatch('open-edit-modal');
    }

    public function editStock()
    {
        dd($this->validate());
    }

    public function addRequest(Stock $stock)
    {
        $this->selectedStock = $stock;
        $this->max_quantity = $stock->item_quantity;
        $this->withdrawForm->stock_id = $stock->id;
        $this->user_id = auth()->id();

        $this->dispatch('open-modal');
    }

    public function saveRequest()
    {
        $currentRequest = Withdraw::where('stock_id', $this->selectedStock->id)->first();
        $validated = $this->validate([
            'requested_quantity' => ['required', 'integer', 'min:1', 'max:' . $this->max_quantity],
        ]);

        if ($currentRequest) {
            $currentRequest->requested_quantity += $validated['requested_quantity'];
            $currentRequest->save();

            return redirect()->route('my-request-list');
        }

        // dd($this->requested_quantity, $this->user_id, $this->stock_id);
        Withdraw::create([
            'requested_quantity' => $validated['requested_quantity'],
            'requested_by' => auth()->id(),
            'received_by' => auth()->id(),
            'stock_id' => $this->withdrawForm->stock_id,
            'user_id' => auth()->id()
        ]);


        return redirect()->route('my-request-list')->with('requested', 'Stock added to request.');
    }

    #[Computed()]
    public function stocks()
    {
        return Stock::latest()->paginate(5);
    }

    public function mount()
    {
        $this->selectedStock = Stock::first() ?? new Stock();
    }

    public function render()
    {
        return view('livewire.components.stock-table', [
            'requests' => Withdraw::where('user_id', auth()->id())->count()
        ]);
    }
}
