<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Illuminate\Bus\Batchable;

class GenerateSingleInvoicePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $tries = 3;
    public $timeout = 600; // 5 minutes

    protected $invoiceId;
    protected $html;
    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $invoiceId
     * @param string $html
     * @param string $filePath Full path to save the PDF
     */
    public function __construct(string $invoiceId, string $html, string $filePath)
    {
        $this->invoiceId = $invoiceId;
        $this->html = $html;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::channel('invoice')->info("[Invoice {$this->invoiceId}] Generating PDF...");

        try {
            Browsershot::html($this->html)
                ->setOption('launch', [
                    'args' => config('browsershot.args', ['--no-sandbox', '--disable-setuid-sandbox', '--disable-gpu']),
                    'executablePath' => config('browsershot.chrome_path', '/bin/google-chrome'),
                    'timeout' => config('browsershot.timeout', 600000),
                    'protocolTimeout' => config('browsershot.protocol_timeout', 600000),

                ])
                ->timeout(600)
                ->format('A4')
                ->waitUntil('load')
                ->showBackground()
                ->save($this->filePath);

            Log::channel('invoice')->info("[Invoice {$this->invoiceId}] PDF saved to {$this->filePath}");

        } catch (\Throwable $e) {
            Log::channel('invoice')->error("[Invoice {$this->invoiceId}] Failed to generate PDF", [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            throw $e; // Allow Laravel to retry
        }
    }
}
