<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\WithdrawForm;
use App\Models\User;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RequestTable extends Component
{
    public $item_quantity;
    public $requested_quantity;
    public $stock_id;
    public $max_quantity;

    public WithdrawForm $withdrawForm;
    public Withdraw $selectedRequest;



    public $approverName;
    public $issueanceName;


    public function viewRequest(Withdraw $withdraw)
    {
        $this->selectedRequest = $withdraw;
        $this->max_quantity = $withdraw->item_quantity;
        $this->withdrawForm->stock_id = $withdraw->stock_id;
        $this->withdrawForm->requested_by = $withdraw->requested_by;
        $this->withdrawForm->received_by = $withdraw->received_by;
        $this->withdrawForm->requested_quantity = $withdraw->requested_quantity;

        // names
        $this->approverName = $withdraw->approvedBy?->name;
        $this->issueanceName = $withdraw->issuedBy?->name;
        $this->dispatch('open-modal');
    }

    #[Computed()]
    public function approveUsers()
    {
        if ($this->selectedRequest) {
            return User::where('id', '!=', $this->selectedRequest->user->id)->get();
        }else {
            return User::where('name', '!=', $this->approverName)->get();
        }
        return collect();
    }

    #[Computed()]
    public function issueanceUsers(){
        if ($this->withdrawForm->approved_by) {
            return User::where('id', '!=', $this->withdrawForm->approved_by)->get();
        }else if($this->approverName){
            return User::where('name', '!=', $this->approverName)->get();
        }

        return collect();
    }

    #[Computed()]
    public function requestAndReceive()
    {
        if ($this->selectedRequest) {
           
            return Withdraw::where('requested_by', $this->selectedRequest->requested_by)
                           ->with('requestedBy') 
                           ->get();
        }
    
        return collect();
    }

    public function update()
    {
        $this->withdrawForm->validate([
            'requested_quantity' => ['required', 'integer', 'min:1', 'max:' . $this->selectedRequest->stock->item_quantity],
        ]);

        $this->withdrawForm->validate();

        $id = $this->withdrawForm->stock_id;
       
        $withdraw = Withdraw::find($id);

        $withdraw->status = ($this->withdrawForm->approved_by && $this->withdrawForm->issued_by);
        $withdraw->requested_quantity = $this->withdrawForm->requested_quantity;
        $withdraw->approved_by = $this->withdrawForm->approved_by;
        $withdraw->issued_by = $this->withdrawForm->issued_by;
        $withdraw->received_by = $this->withdrawForm->requested_by;
        $withdraw->requested_by = $this->withdrawForm->requested_by;
        
        $withdraw->save();

        return redirect()->route('request-list');
    }

    public function delete(Withdraw $withdraw)
    {
        $withdraw->delete();
        $this->dispatch('close-modal');
    }

    public function mount()
    {
        $this->selectedRequest = Withdraw::first() ?? new Withdraw();
    }

    #[Computed()]
    public function requests()
    {
        return Withdraw::paginate(5);
    }

    public function render()
    {
        return view('livewire.components.request-table', [
            'requests' => Withdraw::where('user_id', auth()->id())->count(),
        ]);
    }
}
