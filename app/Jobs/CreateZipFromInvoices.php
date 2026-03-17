<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Illuminate\Bus\Batchable;


class CreateZipFromInvoices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $timeout = 600; // 10 minutes

    protected $pdfDirectory;
    protected $zipPath;

    /**
     * Create a new job instance.
     *
     * @param string $pdfDirectory Path where PDFs are saved
     * @param string $zipPath Full path for the output ZIP
     */
    public function __construct(string $pdfDirectory, string $zipPath)
    {
        $this->pdfDirectory = $pdfDirectory;
        $this->zipPath = $zipPath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::channel('invoice')->info("Creating ZIP at {$this->zipPath}");

        $zip = new ZipArchive();
        if ($zip->open($this->zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $pdfFiles = glob("{$this->pdfDirectory}/*.pdf");

            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();
            Log::channel('invoice')->info("ZIP created successfully at {$this->zipPath}");
        } else {
            Log::channel('invoice')->error("Failed to create ZIP at {$this->zipPath}");
            throw new \RuntimeException("Failed to create ZIP file.");
        }

        // Optional: Clean up PDFs after zipping
        // foreach ($pdfFiles as $file) {
        //     unlink($file);
        // }
    }
}
