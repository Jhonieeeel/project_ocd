<?php

namespace App\Jobs;

use Blaspsoft\Doxswap\Facades\Doxswap;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FileConversionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $docx = Doxswap::convert("ris.docx", "pdf");

        Log::info('Converted DOCX to PDF', ['pdf' => $docx->outputFile]);

       
    }
}
