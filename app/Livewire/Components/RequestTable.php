<?php

namespace App\Livewire\Components;

use App\Models\User;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class RequestTable extends Component
{
    public $users;

    public $approver_id;
    public $issueance_id;

    public $requestedUser;
    public $receivedUser;
    public $requestedId;

    public Withdraw $selectedRequest;


    #[Computed()]
    public function superAdmins(){
        return User::all();
    }
   
    #[Computed()]
    public function admins() {
        return User::where('id', '!=' , $this->approver_id)->get();
    }
    
    public function save() {
        $this->dispatch('update');
    }

    #[On('update')]
    public function approved($id) {
        $current_id = $id;
        $requestedItem = Withdraw::findOrFail($current_id );
        $requestedItem->approved_by = $current_id ;
        $requestedItem->save();
    }
    
    #[On('update')]
    public function issued() {
        $requestedItem = Withdraw::findOrFail($this->issueance_id);
        $requestedItem->issued_by = $this->issueance_id;
        $requestedItem->save();
    }

    public function delete(Withdraw $withdraw) {
        $withdraw->delete();
    }

    public function viewRequest(Withdraw $withdraw) {
        $this->selectedRequest = $withdraw;
        $this->requestedId = $withdraw->id;
        $this->requestedUser = $withdraw->requestedBy->name;
        $this->receivedUser = $withdraw->requestedBy->name;
        $this->dispatch('open-modal');
    }

    public function mount() {
        $this->selectedRequest = Withdraw::first() ?? new Withdraw();
    }
    
    #[On('refresh')]
    #[Computed()]
    public function requests() {
        return Withdraw::paginate(5);
    } 

    public function render()
    {
        return view('livewire.components.request-table', [
            'supplies' => [],
        ]);
    }
}
