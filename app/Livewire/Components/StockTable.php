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

    public $stockSearch;

    public StockForm $stockForm;
    public WithdrawForm $withdrawForm;
    public Stock $selectedStock;

    public function selectEditStock(Stock $stock)
    {
        $this->stockForm->fill($stock->toArray());
        $this->dispatch('open-edit-modal');
    }

    public function editStock()
    {
        $validated = $this->stockForm->validate();
        $stock = Stock::findOrFail($validated['supply_id']);
        if (!$stock) {

            session()->flash('error', 'Stock not found.');
            return;
        }
        $stock->fill($validated)->save();

        session()->flash("edited", "Stock Updated");

        $this->stockForm->reset();
    }

    public function addRequest($id)
    {
        $stock = Stock::findOrFail($id);
        $this->selectedStock = $stock;
        $this->withdrawForm->fill([
            'stock_id' => $stock->id,
            'user_id' => auth()->id(),
            'requested_quantity' => 0,
        ]);
        $this->dispatch('open-modal');
    }

    public function saveRequest()
    {
        $this->withdrawForm->validate([
            'requested_quantity' => 'required|integer|min:1|max:' . $this->selectedStock->item_quantity,
            'stock_id' => 'required|exists:stocks,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $userRequest = Withdraw::where('user_id', auth()->id())
            ->where('stock_id', $this->withdrawForm->stock_id)
            ->first();
        if ($userRequest) {
            $userRequest->requested_quantity += $this->withdrawForm->requested_quantity;
            $userRequest->save();
        } else {
            Withdraw::create([
                'stock_id' => $this->withdrawForm->stock_id,
                'user_id' => $this->withdrawForm->user_id,
                'requested_quantity' => $this->withdrawForm->requested_quantity,
            ]);
        }


        return redirect()->route('my-request-list')->with('requested', 'Stock added to request.');
    }

    #[Computed()]
    public function stocks()
    {
        if ($this->stockSearch) {
            return Stock::whereHas('supply', function ($query) {
                $query->where('item_description', 'like', "%{$this->stockSearch}%");
            })->paginate(5);
        }

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
