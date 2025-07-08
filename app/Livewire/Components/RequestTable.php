<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\WithdrawForm;
use App\Models\ApprovedWithdraw;
use App\Models\User;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;

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

    public $approved_date;
    public $issued_date;
    public $requested_date;
    public $received_date;
    public $status = false;

    public $printWithdraw;

    public function viewRequest(Withdraw $withdraw)
    {
        $this->selectedRequest = $withdraw;
        $this->max_quantity = $withdraw->item_quantity;
        $this->withdrawForm->stock_id = $withdraw->stock_id;
        $this->withdrawForm->requested_by = $withdraw->requested_by;
        $this->withdrawForm->received_by = $withdraw->received_by;
        $this->withdrawForm->requested_quantity = $withdraw->requested_quantity;

        // status
        $this->withdrawForm->status = $withdraw->status ? true : false;

        // names
        $this->approverName = $withdraw->approvedBy?->name;
        $this->issueanceName = $withdraw->issuedBy?->name;

        // dates
        $this->approved_date = $withdraw->approved_date;
        $this->issued_date = $withdraw->issued_date;
        $this->requested_date = $withdraw->requested_date;
        $this->received_date = $withdraw->received_date;
        $this->dispatch('open-modal');
    }

    #[Computed()]
    public function approveUsers()
    {
        if ($this->selectedRequest) {
            return User::where('id', '!=', $this->selectedRequest->user->id)->get();
        } else {
            return User::where('name', '!=', $this->approverName)->get();
        }
        return collect();
    }

    #[Computed()]
    public function issueanceUsers()
    {
        return User::role('issueance')->get();
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

        if (!$withdraw->status) {
            $withdraw->status = ($this->withdrawForm->approved_by && $this->withdrawForm->issued_by);
        } else {
            $withdraw->status = false;
        }

        $withdraw->requested_quantity = $this->withdrawForm->requested_quantity;
        $withdraw->approved_by = $this->withdrawForm->approved_by;
        $withdraw->issued_by = $this->withdrawForm->issued_by;
        $withdraw->received_by = $this->withdrawForm->requested_by;
        $withdraw->requested_by = $this->withdrawForm->requested_by;

        // date
        $withdraw->requested_date = ($this->withdrawForm->requested_by ? now()->toDateString() : null);
        $withdraw->received_date = ($this->withdrawForm->received_by ? now()->toDateString() : null);
        $withdraw->approved_date = ($this->withdrawForm->approved_by ? now()->toDateString() : null);
        $withdraw->issued_date = ($this->withdrawForm->issued_by ? now()->toDateString() : null);

        $withdraw->save();

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
