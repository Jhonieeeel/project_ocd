<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\WithdrawForm;
use App\Models\ApprovedWithdraw;
use App\Models\User;
use App\Models\Withdraw;
use Livewire\Attributes\Computed;
use Livewire\Component;
use NcJoes\OfficeConverter\OfficeConverter;
use PhpOffice\PhpWord\TemplateProcessor;


<<<<<<< HEAD
use PhpOffice\PhpWord\TemplateProcessor;
use Spatie\Permission\Models\Role;

class RequestTable extends Component
{
    public $roles;
    public $users;
=======
use PhpOffice\PhpWord\PhpWord;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpWord\Metadata\Settings;

class RequestTable extends Component
{
    // use Printing;
>>>>>>> 6193748fe6fc8a41b43940783ed5a35ef1f7a533

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
<<<<<<< HEAD
            'requested_quantity' => (int) $validated['requested_quantity'],
=======
            'requested_quantity' => $validated['requested_quantity'],
>>>>>>> 6193748fe6fc8a41b43940783ed5a35ef1f7a533
            'approved_by' => (int) $validated['approved_by'] ?: null,
            'issued_by' => (int) $validated['issued_by'] ?: null,
            'received_by' => (int) $validated['received_by'] ?: null,
            'status' => ($validated['approved_by'] && $validated['issued_by'] && $validated['received_by'] && $validated['requested_by'])
        ]);
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

        // PDF CONVERSION
        $inputPath = public_path('docs/ris.docx');
        $outputPath = public_path('docs');
        $pdfFile = $outputPath . '/ris.pdf'; // Output filename LibreOffice will generate

        // Ensure HOME is set (important for Windows + LibreOffice)
        if (!getenv('HOME')) {
            putenv('HOME=' . storage_path());
        }

        // Properly quoted path to handle spaces in "Program Files"
        $libreOfficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';

        // Build and run the conversion command
        $command = "{$libreOfficePath} --headless --convert-to pdf \"{$inputPath}\" --outdir \"{$outputPath}\"";
        exec($command . ' 2>&1', $output, $returnCode);

        // Debug output if needed:
        // dd(['cmd' => $command, 'output' => $output, 'return_code' => $returnCode]);

        if (file_exists($pdfFile)) {
            // Dispatch event to open/print the PDF in the browser
            $this->dispatch('print-docs', [
                'url' => asset('docs/ris.pdf'),
            ]);
        } else {
            $this->dispatch('print-docs', [
                'url' => null,
                'error' => 'PDF conversion failed.',
                'details' => $output,
            ]);
        }


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
