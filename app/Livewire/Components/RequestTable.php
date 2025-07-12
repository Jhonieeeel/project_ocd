<?php

namespace App\Livewire\Components;

use App\Jobs\FileConversionJob;
use App\Jobs\GenerateWordPdfJob;
use App\Livewire\Forms\WithdrawForm;
use App\Models\ApprovedWithdraw;
use App\Models\User;
use App\Models\Withdraw;
use Spatie\Permission\Models\Role;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class RequestTable extends Component
{
    public $roles;
    public $users;
    public $requestSearch;

    public WithdrawForm $withdrawForm;
    public Withdraw $selectedRequest;

    public $printWithdraw;

    public function viewRequest(Withdraw $withdraw)
    {
        $this->selectedRequest = $withdraw;
        $this->withdrawForm->fill($withdraw->toArray());

        $this->dispatch('open-modal');
    }

    #[Computed()]
    public function approveUsers()
    {
        return User::where('id', '!=', $this->withdrawForm->requested_by)->get();
    }

    #[Computed()]
    public function issueanceUsers()
    {
        return User::role('issueance')->get();
    }

    #[Computed()]
    public function userRoles()
    {
        return Role::all();
    }

    #[Computed()]
    public function receivers()
    {
        return User::role($this->roles)->get();
    }

    public function update()
    {
        $this->withdrawForm->validate([
            'requested_quantity' => ['required', 'integer', 'min:1', 'max:' . $this->selectedRequest->stock->item_quantity],
        ]);

        $validated = $this->withdrawForm->validate();

        $withdraw = Withdraw::find($this->selectedRequest->id);

        $withdraw->update([
            'ris' => $validated['ris'],
            'requested_quantity' => (int) $validated['requested_quantity'],
            'approved_by' => (int) $validated['approved_by'] ?: null,
            'issued_by' => (int) $validated['issued_by'] ?: null,
            'received_by' => (int) $validated['received_by'] ?: null,
            'requested_by' => (int) $validated['requested_by'] ?: null,
            'status' => ($validated['approved_by'] && $validated['issued_by'] && $validated['received_by'] && $validated['requested_by']),
        ]);

        session()->flash('withdraw_updated', "Withdraw Request Updated Successfully");
        $this->dispatch('close-modal');
    }



    public function success($withdraw_id)
    {
        $this->printWithdraw = Withdraw::find($withdraw_id);

        $approved = ApprovedWithdraw::create([
            'withdraw_id' => $this->printWithdraw->id,
        ]);

        if ($approved) {
            // GenerateWordPdfJob::dispatch($this->printWithdraw);
            // FileConversionJob::dispatch();
            $this->dispatch('open-success-modal');
        }
    }

    public function printRIS(Withdraw $withdraw)
    {

        $approvedWithdraw = ApprovedWithdraw::find($withdraw->id);

        session()->flash('printed_created', "New print record added");
    }

    #[On('print-docs')]
    public function incrementPrintTimes($data)
    {
        $id = $data['approved_id'] ?? null;
        $increment = ApprovedWithdraw::find($id);
        $increment->printed_times += 1;
        $increment->save();
    }


    public function delete(Withdraw $withdraw)
    {
        $withdraw->delete();
        $this->dispatch('close-modal');
        $this->redirect(route('request-list'), navigate: true);
    }

    #[Computed()]
    public function requests()
    {

        if ($this->requestSearch) {
            return Withdraw::whereHas('stock.supply', function ($query) {
                $query->where('item_description', 'like', "%{$this->requestSearch}%");
            })->paginate(5);
        }

        return Withdraw::paginate(5);
    }

    public function render()
    {
        return view('livewire.components.request-table', [
            'requests' => Withdraw::where('user_id', auth()->id())->count(),
        ]);
    }
}
