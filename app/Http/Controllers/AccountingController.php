<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Register;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Jobs\GenerateInvoicePdf;
use App\Jobs\CreateInvoiceZip;
use App\Jobs\CheckBatchCompletion;
use Illuminate\Support\Facades\Bus;
use App\Jobs\GenerateSingleInvoicePdf;
use App\Jobs\CreateZipFromInvoices;
use Illuminate\Bus\Batch;
use Throwable; // Add at top if not imported

class AccountingController extends Controller
{
    public function upcomingStatement()
    {
        $startOfNextMonth = Carbon::now()->startOfMonth()->addMonth();
        $endOfNextMonth = $startOfNextMonth->copy()->endOfMonth();

        // Fetch only active customers whose start_date is in next month
        $customers = Register::where('status', 'Active')
            ->whereBetween('start_date', [$startOfNextMonth, $endOfNextMonth])
            ->get();

        $total = $customers->count();

        return view('upcoming_statement.index', compact('customers', 'total'));
    }


    public function upcomingInvoiceGenerate(Request $request)
    {
        try {
            $customerIds = $request->input('customer_ids', []);
            Log::info('Received customer IDs: ' . json_encode($customerIds));
            if (empty($customerIds)) {
                return response()->json(['success' => false, 'message' => 'No customer IDs provided'], 400);
            }

            foreach ($customerIds as $id) {
                Log::info('Processing customer ID: ' . $id);
                $customer = Register::with('ipAddresses')->find($id);
                
                if (!$customer) {
                    Log::warning('Customer not found for ID: ' . $id);
                    continue;
                }
                Log::info('Customer found: ' . json_encode($customer->toArray()));

                // Retrieve and set defaults for calculations
                $number_of_invoices = $customer->number_of_invoices ?? 0;
                $installation_fee = $customer->installation_fee ?? 0;
                $internet_fee = $customer->internet_fee ?? 0;
                $ip_fee = $customer->ip_fee ?? 0;
                $ip_quantity = $customer->ipAddresses->count() ?? 0;
                $bill_cycle = $customer->bill_cycle ?? 1;

                // Determine if installation fee should be included
                $installation_or_not = ($number_of_invoices != 0 || $installation_fee == 0) ? 'false' : 'true';
                $include_installation_fee = ($installation_or_not === 'true') ? round($installation_fee, 2) : 0.00;

                // Calculate total fees with decimal precision
                $internet_fee_total = round($internet_fee, 2);
                $ip_total = round($ip_fee * $ip_quantity, 2);
                $total_amount = round($internet_fee_total + $ip_total + $include_installation_fee, 2);

                // Set created_at to the first day of the month of start_date
                $start_date = $customer->start_date ?? now();
                $created_at = \Carbon\Carbon::parse($start_date)->startOfMonth()->toDateTimeString();

                // Log the calculated created_at for debugging
                Log::info('Calculated created_at for customer ID ' . $id . ': ' . $created_at);

                // Create the invoice with explicit timestamp override
                $invoice = new Invoice([
                    'customer_id' => $customer->customer_id,
                    'customer_name' => $customer->customer_name,
                    'address_line_1' => $customer->address_line_1 ?? 'N/A',
                    'alt_customer_name' => $customer->alt_customer_name ?? '',
                    'alt_address_line_1' => $customer->alt_address_line_1 ?? '',
                    'tariff_name' => $customer->tariff_name ?? '',
                    'bandwidth' => $customer->bandwidth ?? '',
                    'internet_fee' => $internet_fee,
                    'bill_cycle' => $bill_cycle,
                    'installation_or_not' => $installation_or_not,
                    'installation_fee' => $installation_fee,
                    'installation_quantity' => $customer->installation_quantity ?? 1,
                    'ip_fee' => $ip_fee,
                    'ip_quantity' => $ip_quantity,
                    'total_amount' => $total_amount,
                    'payment_status' => 'Unpaid',
                    'payment_date' => null,
                    'start_date' => $start_date,
                    'end_date' => $customer->end_date ?? date('Y-m-d', strtotime(now() . ' + ' . $bill_cycle . ' months')),
                    'last_updated' => now(),
                    'update_attempts' => 0,
                    'created_by' => Auth::check() ? Auth::user()->name : 'Unknown',
                    'updated_by' => Auth::check() ? Auth::user()->name : 'Unknown',
                    'created_at' => $created_at,
                    'updated_at' => now(),
                ]);
                $invoice->setAttribute('created_at', $created_at);
                $invoice->save();

                // Update customer record
                DB::table('customers_info')
                    ->where('customer_id', $customer->customer_id)
                    ->update([
                        'number_of_invoices' => $number_of_invoices + 1,
                        'start_date' => $customer->end_date ?? now(),
                        'end_date' => date('Y-m-d', strtotime(($customer->end_date ?? now()) . ' + ' . $bill_cycle . ' months')),
                    ]);
            }

            return response()->json(['success' => true, 'message' => 'Invoices generated successfully']);
        } catch (\Exception $e) {
            Log::error('Invoice generation error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function viewAndDownloadInvoices()
    {
        // Get the current date
        $currentDate = Carbon::today(); // Today is June 6, 2025

        // Calculate the 1st of the next month
        $nextMonthFirst = $currentDate->copy()->addMonth()->startOfMonth(); // July 1, 2025

        // Filter invoices where created_at is exactly the 1st of the next month
        $invoices = Invoice::whereDate('created_at', $nextMonthFirst)->get();
        $total = $invoices->count();
        $totalAmount = $invoices->sum('total_amount');

        // Pass the filtered invoices to the view
        return view('view_and_download_invoices.index', compact('invoices', 'total', 'totalAmount'));
    }
    


    public function downloadAllInvoicesAsZip(Request $request)
    {
        $province = trim($request->query('province', ''));
    
        $query = Invoice::query();
    
        $nextMonth = Carbon::now()->addMonth();
        $query->whereDate('created_at', '>=', $nextMonth->copy()->startOfMonth())
              ->whereDate('created_at', '<=', $nextMonth->copy()->endOfMonth());
    
        if ($province !== '') {
            Log::channel('invoice')->info("📍 Applying province filter", ['province' => $province]);
            $query->whereHas('customer', function ($q) use ($province) {
                $q->where('province', $province);
            });
        } else {
            Log::channel('invoice')->info("⚠️ No province filter applied, fetching all invoices.");
        }
    
        $invoices = $query->get();
        $invoiceCount = $invoices->count();
        Log::channel('invoice')->info("📄 Retrieved invoice count: {$invoiceCount}");
    
        if ($invoices->isEmpty()) {
            return response()->json([
                'message' => 'No invoices found for the specified criteria.',
            ]);
        }
    
        // Construct ZIP file name with province slug and next month/year
        $month = $nextMonth->format('F'); // e.g., July
        $year = $nextMonth->format('Y');  // e.g., 2025
        $provinceSlug = $province !== '' ? preg_replace('/\s+/', '', $province) : 'AllProvinces';
        $fileName = "AllInvoiceFor{$provinceSlug}{$month}{$year}.zip";
        
    
        // $zipPath = public_path('invoices/download-zip/' . $fileName);
        // $downloadUrl = url('invoices/download-zip/' . basename($zipPath));
        
        $zipPath = base_path('public/invoices-generate/download-zip/' . $fileName);
        $downloadUrl = url('invoices/download-zip/' . $fileName);

    
        // ✅ Check cached invoice count to decide if ZIP can be served directly
        $cacheKey = "zip_invoice_count_{$provinceSlug}_{$month}_{$year}";
        $cachedCount = Cache::get($cacheKey);
    
        if (file_exists($zipPath) && $cachedCount == $invoiceCount) {
            Log::channel('invoice')->info("✅ Serving existing ZIP for {$provinceSlug}. Invoice count matches cached count: {$invoiceCount}.");
    
            return response()->json([
                'message' => 'ZIP file already exists. Serving cached version.',
                'invoice_count' => $invoiceCount,
                'zip_path' => $zipPath,
                'download_url' => $downloadUrl,
                'zip_file_name' => $fileName,
            ]);
        } else {
            Log::channel('invoice')->info("♻️ Invoice count changed or ZIP missing. Generating new ZIP. Old: {$cachedCount}, New: {$invoiceCount}");
        }
    
        // Directory to store individual PDFs
        $pdfDirectory = "/mnt/ramdisk/invoices/" . Str::uuid()->toString();
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0755, true);
        }
    
        // Prepare GenerateSingleInvoicePdf jobs
        $jobs = [];
        foreach ($invoices as $invoice) {
            $html = view('invoices.print', ['invoice' => $invoice])->render();
            $invoiceId = $invoice->invoice_id;
            $pdfFileName = 'invoice_' . str_pad($invoiceId, 6, '0', STR_PAD_LEFT) . '.pdf';
            $pdfFilePath = $pdfDirectory . '/' . $pdfFileName;
    
            $jobs[] = (new GenerateSingleInvoicePdf($invoiceId, $html, $pdfFilePath))
                ->onQueue('heavy');
        }
    
        // Dispatch batch with final ZIP job chained
        Bus::batch($jobs)
            ->then(function (Batch $batch) use ($pdfDirectory, $zipPath, $cacheKey, $invoiceCount) {
                // Dispatch ZIP creation job
                CreateZipFromInvoices::dispatch($pdfDirectory, $zipPath);
    
                // Update cached invoice count after successful generation
                Cache::put($cacheKey, $invoiceCount);
                Log::channel('invoice')->info("✅ All invoices generated. ZIP job dispatched. Cache updated for key: {$cacheKey}");
            })
            ->catch(function (Batch $batch, \Throwable $e) {
                Log::channel('invoice')->error("❌ Invoice batch failed: {$e->getMessage()}");
            })
            ->finally(function (Batch $batch) {
                Log::channel('invoice')->info("ℹ️ Invoice batch finished. ID: {$batch->id}");
            })
            ->dispatch();
    
        return response()->json([
            'message' => 'Invoice PDF generation batch dispatched.',
            'invoice_count' => $invoiceCount,
            'zip_path' => $zipPath,
            'download_url' => $downloadUrl,
            'zip_file_name' => $fileName,
        ]);
    }




    public function downloadZip($filename, Request $request)
    {
        $sanitizedFilename = basename($filename);
        // $path = "/home/fastoneisp/public_html/invoices/download-zip/{$sanitizedFilename}";
        
        $path = base_path("public/invoices-generate/download-zip/{$sanitizedFilename}");

    
        if (!file_exists($path)) {
            Log::warning("ZIP download failed. File not found: {$path}");
    
            return response()->json([
                'error' => 'ZIP file not ready or does not exist.',
                'filename' => $sanitizedFilename,
                'path' => $path,
            ], 404);
        }
    
        // Optional: HEAD request support (check status from frontend)
        if ($request->isMethod('head')) {
            return response()->noContent(200)->header('Content-Type', 'application/zip');
        }
    
        Log::info("✅ ZIP download successful: {$path}");
    
        return response()->download($path, $sanitizedFilename);
    }









}