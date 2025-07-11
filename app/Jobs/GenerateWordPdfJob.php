<?php

namespace App\Jobs;

use App\Models\ApprovedWithdraw;
use App\Models\Withdraw;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class GenerateWordPdfJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Withdraw $withdraw)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $approvedWithdraw = ApprovedWithdraw::where('withdraw_id', $this->withdraw->id)->first();

        if (!$approvedWithdraw) {
            Log::error('No ApprovedWithdraw found', ['withdraw_id' => $this->withdraw->id]);
            return;
        }


        // if (!$approvedWithdraw) {
        //     throw new \Exception("No approvedWithdraw found for withdraw ID {$this->withdraw->id}");
        // }

        // $template = new TemplateProcessor(public_path('docs/ris.docx'));

        // $template->setValue('entity_name', '');
        // $template->setValue('fund_cluster', '');
        // $template->setValue('division', $this->withdraw->user->division);
        // $template->setValue('office', $this->withdraw->user->office);
        // $template->setValue('ris_no', $this->withdraw->ris . '-' . $approvedWithdraw->printed_times);
        // $template->setValue('res_code', '');

        // $template->cloneRowAndSetValues('stock_no', [[
        //     'stock_no' => $this->withdraw->stock->barcode,
        //     'unit' => $this->withdraw->stock->supply->unit,
        //     'item' => $this->withdraw->stock->supply->item_description,
        //     'req_qty' => $this->withdraw->requested_quantity,
        //     'yes' => '',
        //     'no' => '',
        //     'issueQty' => '',
        //     'remarks' => $this->withdraw->stock->remarks
        // ]]);

        // $template->setValue('purpose', '');
        // $template->setValue('requested', $this->withdraw->requestedBy->name);
        // $template->setValue('approved', $this->withdraw->approvedBy->name);
        // $template->setValue('issued', $this->withdraw->issuedBy->name);
        // $template->setValue('received', $this->withdraw->receivedBy->name);

        // $baseFilename = "{$this->withdraw->ris}-{$this->withdraw->approvedWithdraw->printed_times}";
        // $tempDocx = storage_path("app/temp/{$baseFilename}.docx");
        // $tempPdf = storage_path("app/temp/{$baseFilename}.pdf");

        // Storage::makeDirectory('temp');
        // $template->saveAs($tempDocx);

        // // LibreOffice PDF conversion
        // if (!getenv('HOME')) {
        //     putenv('HOME=' . storage_path());
        // }

        // $libreOfficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
        // $command = "{$libreOfficePath} --headless --convert-to pdf \"{$tempDocx}\" --outdir \"" . storage_path('app/temp') . '"';
        // exec($command . ' 2>&1', $output, $returnCode);

        // if (file_exists($tempPdf)) {
        //     Storage::makeDirectory('approved');

        //     $storagePath = "approved/{$baseFilename}.pdf";
        //     Storage::put($storagePath, file_get_contents($tempPdf));

        //     $approvedWithdraw->update([
        //         'filepath' => $storagePath,
        //     ]);

        //     unlink($tempDocx);
        //     unlink($tempPdf);
        // }
    }
}
