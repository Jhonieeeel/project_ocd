<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\StockForm;
use App\Livewire\Forms\SupplyForm;
use App\Models\Stock;
use App\Models\Supply;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SupplyTable extends Component
{
    use WithPagination, WithFileUploads;

    public $categories = ['supplies', 'nfi', 'fuel', 'others'];
    public $units = ['pc', 'pack', 'sachet', 'unit', 'ream', 'box', 'set', 'meter', 'kg', 'bag', 'case', 'kit', 'lot', 'bucket', 'galon', 'crate', 'bottle',];
    public $supplySearch;

    public SupplyForm $supplyForm;
    public StockForm $stockForm;
    public Supply $selectedSupply;


    public function addStock(Supply $supply)
    {
        $this->selectedSupply = $supply;
        $this->stockForm->supply_id = $supply->id;
        $this->dispatch('open-modal');
    }

    public function saveSupply()
    {
        $this->supplyForm->validate();

        $imagePath = null;

        if ($this->supplyForm->image) {
            $imagePath = $this->supplyForm->image->store('supplies', 'public');
        }

        Supply::create([
            'item_description' => $this->supplyForm->item_description,
            'category' => $this->supplyForm->category,
            'unit' => $this->supplyForm->unit,
            'image' => $imagePath,
        ]);

        session()->flash('status', 'Supply added.');

        $this->supplyForm->reset(['image', 'item_description', 'unit', 'category']);
    }

    public function saveStock()
    {
        $this->stockForm->validate();

        Stock::create([
            'barcode' => $this->stockForm->barcode,
            'item_price' => $this->stockForm->item_price,
            'item_quantity' => $this->stockForm->item_quantity,
            'remarks' => $this->stockForm->remarks,
            'expiration' => $this->stockForm->expiration,
            'supply_id' => $this->stockForm->supply_id
        ]);

        $this->reset(['stockForm.barcode', 'stockForm.item_quantity', 'stockForm.item_price']);

        $this->dispatch('close-modal');

        return redirect()->route('stocks')->with('stock', 'Stock added!');
    }

    public function delete(Supply $supply)
    {
        $supply->delete();

        session()->flash('deleted', 'Supply added.');
    }

    public function mount()
    {
        $this->selectedSupply = Supply::first() ?? new Supply();
    }

    #[Computed()]
    public function supplies()
    {
        if ($this->supplySearch) {
            return Supply::where('item_description', 'like', "%{$this->supplySearch}%")->get();
        }

        return Supply::latest()->paginate(5);
    }

    public function render()
    {
        return view('livewire.components.supply-table', [
            'categories' => $this->categories,
            'units' => $this->units
        ]);
    }
}
