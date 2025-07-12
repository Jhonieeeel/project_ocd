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

        Log::info("Generating Word and PDF for Approved Withdraw ID: {$approvedWithdraw->id}");

        $template = new TemplateProcessor(public_path('docs/ris.docx'));

        $template->setValue('entity_name', '');
        $template->setValue('fund_cluster', '');
        $template->setValue('division', $this->withdraw->user->division);
        $template->setValue('office', $this->withdraw->user->office);
        $template->setValue('ris_no', $this->withdraw->ris. '-' . $approvedWithdraw->printed_times);
        $template->setValue('res_code', '');

        $template->cloneRowAndSetValues('stock_no', [[
            'stock_no' => $this->withdraw->stock->barcode,
            'unit' => $this->withdraw->stock->supply->unit,
            'item' => $this->withdraw->stock->supply->item_description,
            'req_qty' => $this->withdraw->requested_quantity,
            'yes' => '',
            'no' => '',
            'issueQty' => '',
            'remarks' => $this->withdraw->stock->remarks
        ]]);

        $template->setValue('purpose', '');
        $template->setValue('requested', $this->withdraw->requestedBy->name);
        $template->setValue('approved', $this->withdraw->approvedBy->name);
        $template->setValue('issued', $this->withdraw->issuedBy->name);
        $template->setValue('received', $this->withdraw->receivedBy->name);

        $temp = storage_path("app/temp_" . time() . ".docx");

        $template->saveAs($temp);

        if (!file_exists($temp)) {
            throw new \Exception("Failed to save generated Word file at: {$temp}");
        }


        // LibreOffice PDF conversion

        $pdfOutputPath = storage_path("app/ris");
        $docxInfo = pathinfo($temp, PATHINFO_FILENAME);
        $pdfPath = "{$pdfOutputPath}/{$docxInfo}.pdf";

        if (!getenv('HOME')) {
            putenv('HOME=' . storage_path());
        }

        $libreOfficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
        $command = "{$libreOfficePath} --headless --convert-to pdf --outdir \"{$pdfOutputPath}\" \"{$temp}\"";
        exec($command . ' 2>&1', $output, $returnCode);


        $userName = preg_replace('/\s+/', '_', trim($this->withdraw->user->name));
        $pdfName = "{$userName}_{$this->withdraw->ris}.pdf";
        Storage::disk('public')->put("ris/{$pdfName}", file_get_contents($pdfPath));


        $approvedWithdraw->filepath = "ris/{$pdfName}";
        $approvedWithdraw->printed_times += 1;
        $approvedWithdraw->save();
        Log::info("PDF generated and saved as: {$pdfName}");

        if (file_exists($temp)) {
            unlink($temp);
            unlink($pdfPath);
        } else {
            Log::error("Failed to delete temporary file: {$temp}");
        }
    }
}
