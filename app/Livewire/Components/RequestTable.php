<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\WithdrawForm;
use App\Models\User;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;

class RequestTable extends Component
{
    public $requestedId;
    public $item_quantity;

    public Withdraw $selectedRequest;

    public $requested_quantity;
    public $approver_id;
    public $issueance_id;
    public $requestedUser;
    public $receivedUser;

    public WithdrawForm $withdrawForm;

    #[Computed()]
    public function superAdmins()
    {
        if ($this->selectedRequest) {
            return User::where('id', '!=', $this->selectedRequest->user->id)->get();
        }

        return User::all();
    }

    #[Computed()]
    public function admins()
    {
        if ($this->issueance_id) {
            return User::where('id', '!=', $this->approver_id)->get();
        }
        return User::all();
    }


    public function update()
    {
        $this->withdrawForm->received_by = $this->selectedRequest->received_by;
        $this->withdrawForm->requested_by = $this->selectedRequest->requested_by;
        $this->withdrawForm->approved_by = $this->approver_id;
        $this->withdrawForm->issued_by = $this->issueance_id;

        $requested = Withdraw::find($this->selectedRequest->id);
        if ($requested) {
            if ($this->approver_id && $this->issueance_id) {
                $this->withdrawForm->status = true;
            }
            $this->withdrawForm->status = false;
            $this->withdrawForm->validate();

            $validated = $this->validate([
                'requested_quantity' => ['required', 'integer', 'min:1', 'max:' . $this->selectedRequest->stock->item_quantity],
            ]);

            $requested->requested_quantity = $validated['requested_quantity'];

            $requested->save();

            dd($this->withdrawForm->approved_by);

            return redirect()->route('request-list');
        }

        return redirect()->route('request-list');
    }

    public function delete(Withdraw $withdraw)
    {
        $withdraw->delete();

        $this->dispatch('close-modal');
    }

    public function viewRequest(Withdraw $withdraw)
    {
        $this->selectedRequest = $withdraw;
        $this->requestedId = $withdraw->id;
        $this->requestedUser = $withdraw->requestedBy->name;
        $this->receivedUser = $withdraw->requestedBy->name;
        $this->requested_quantity =  $withdraw->requested_quantity;
        $this->dispatch('open-modal');
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
