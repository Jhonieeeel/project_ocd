<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\WithdrawForm;
use App\Models\ApprovedWithdraw;
use App\Models\User;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;

use PhpOffice\PhpWord\TemplateProcessor;
use Spatie\Permission\Models\Role;

class RequestTable extends Component
{
    public $roles;
    public $users;

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
        return User::where('id', '!=', $this->withdrawForm->user_id)->get();
    }

    #[Computed()]
    public function issueanceUsers()
    {
        return User::role('issueance')->get();
    }

    #[Computed()]
    public function userRoles() {
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
            'status' => ($validated['approved_by'] && $validated['issued_by'] && $validated['received_by'] && $validated['requested_by'])
        ]);

        return redirect()->route('request-list');
    }


    public function success($withdraw_id)
    {
        $this->printWithdraw = Withdraw::find($withdraw_id);
        $this->dispatch('open-success-modal');
    }

    public function printRIS($withdraw_id)
    {

        $approvedWithdraw = ApprovedWithdraw::find($withdraw_id);
        if ($approvedWithdraw) {
            $approvedWithdraw->printed_times += 1;
            $approvedWithdraw->save();
            session()->flash('printed_created', "Item Printed Successfully");
        } else {
            ApprovedWithdraw::create([
                'withdraw_id' => $withdraw_id,
                'printed_times' => 1
            ]);
        }

        $ris_docs = new TemplateProcessor(public_path('docs/ris.docx'));
        dd($ris_docs->getVariables());
        $ris_docs->setValue('entity_name', 'John');
        $ris_docs->setValue('fund_cluster ', 'Find Cluster');
        $ris_docs->setValue('division', 'Division ');
        $ris_docs->setValue('res_code ', 'Responsibility Code');
        $ris_docs->setValue('office ', 'Office');
        $ris_docs->setValue('ris_no ', 'RIS No.');

        $ris_docs->cloneRowAndSetValues('stock_no', [
            [
                'stock_no' => $approvedWithdraw->withdraw->stock->barcode,
                'unit' => $approvedWithdraw->withdraw->stock->supply->unit,
                'item' => $approvedWithdraw->withdraw->stock->supply->item_description,
                'req_qty' => $approvedWithdraw->withdraw->requested_quantity,
                'yes' => '',
                'no' => '',
                'issue_qty' => '',
                'remarks' => $approvedWithdraw->withdraw->remarks,
                'purpose' => '',
                'req_by' => $approvedWithdraw->withdraw->requestedBy->name,
                'approved_by' => $approvedWithdraw->withdraw->approvedBy->name,
                'issue_by' => $approvedWithdraw->withdraw->issuedBy->name,
                'received_by' => $approvedWithdraw->withdraw->receivedBy->name,
                'designation' => ''
            ]
        ]);
        // Printing functions here
        $docs_path = public_path('ris_docs/generated_ris.docx');
        $ris_docs->saveAs($docs_path);

        session()->flash('printed_created', "New print record added");
    }

    public function delete(Withdraw $withdraw)
    {
        $withdraw->delete();
        $this->dispatch('close-modal');
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
