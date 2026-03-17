<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Register;
use Illuminate\Http\Request;
use App\Models\IpAddress; // make sure you have this model


class InvoiceController extends Controller
{
    public function index()
    {
        // Get all invoices
        $invoices = Invoice::with('customer')->get();
        // Get the total invoices
        $total_invoices = $invoices->count();
        // Get the total amount of all invoices
        $total_amount = $invoices->sum('total_amount');
        //get the total amount of all paid invoices
        $total_paid = $invoices->where('payment_status', 'Paid')->sum('total_amount');
        //get the total amount of all unpaid invoices   
        $total_unpaid = $invoices->where('payment_status', 'Unpaid')->sum('total_amount');
        //get the total paid invoices
        $total_paid_invoices = $invoices->where('payment_status', 'Paid')->count();
        //get the total unpaid invoices
        $total_unpaid_invoices = $invoices->where('payment_status', 'Unpaid')->count();
        // Pass the data to the view
        return view('invoices.index', compact('invoices', 'total_invoices', 'total_amount', 'total_paid', 'total_unpaid', 'total_paid_invoices', 'total_unpaid_invoices'));
    }

    public function create()
    {
        $customers = Register::all();

        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers_info,customer_id',
            'start_date_input' => 'required|date',
            'end_date_input' => 'required|date|after:start_date',
            'internet_fee_input' => 'required|numeric|min:0',
            'installation_fee_input' => 'nullable|numeric|min:0',
            'installation_quantity_input' => 'nullable|integer|min:1',
            'bill_cycle_input' => 'required|integer|min:1',
            'total_amount_input' => 'required|numeric|min:0',
        ]);
    
        $customer = Register::with('ipAddresses')->findOrFail($request->customer_id);
        $ip_quantity = $customer->ipAddresses->count();

    
        // Calculate amounts
        $internet_fee = (float) $request->internet_fee_input;
        $installation_fee = (float) ($request->installation_fee_input ?? 0);
        $installation_quantity = (int) ($request->installation_quantity_input ?? 1);
        $total_amount = (float) $request->total_amount_input;
        $amount_of_invoices = (int) $customer->number_of_invoices;

        $installation_or_not = ($amount_of_invoices !== 0 or $installation_fee == 0) ? 'false' : 'true';
        $installation_or_not = (string) $installation_or_not;

        Invoice::create([
            'customer_id' => $customer->customer_id,
            'customer_name' => $customer->customer_name,
            'address_line_1' => $customer->address_line_1,
            'alt_customer_name' => $customer->alt_customer_name ?? '',
            'alt_address_line_1' => $customer->alt_address_line_1 ?? '',
            'tariff_name' => $customer->tariff_name, // Optional: Just a placeholder or remove this column from DB if unused
            'bandwidth' => $customer->bandwidth,
    
            'internet_fee' => $internet_fee,
            'installation_or_not' => $installation_or_not,
            'installation_fee' => $installation_fee,
            'installation_quantity' => $installation_quantity,
            'ip_fee' => $customer->ip_fee,
            'ip_quantity' => $ip_quantity,
    
            'total_amount' => $total_amount,
            'payment_status' => 'Unpaid',
    
            'start_date' => $request->start_date_input,
            'end_date' => $request->end_date_input,
            'bill_cycle' => $request->bill_cycle_input,
            ]);

            $customer->number_of_invoices += 1;
            $customer->start_date = $request->end_date_input;
            $customer->end_date = date('Y-m-d', strtotime($request->end_date_input . ' + ' . $customer->bill_cycle . ' months'));
            $customer->save(); // this updates customer_info table

    
        return redirect('/unpaid-invoices')->with('success', 'Invoice created successfully!');
    }
    
    
    public function getCustomerInf($id)
    {
        $customer = Register::findOrFail($id);
    
        // Count how many IP addresses belong to this customer_id
        $ip_quantity = IpAddress::where('customer_id', $customer->customer_id)->count();
    
        return response()->json([
            'customer_name' => $customer->customer_name,
            'tariff_name' => $customer->tariff_name,
            'bandwidth' => $customer->bandwidth,
            'start_date' => $customer->start_date,
            'end_date' => $customer->end_date,
            'due_date' => $customer->due_date,
            'address' => $customer->address_line_1,
            'alt_address' => $customer->alt_address_line_1,
            'bill_cycle' => $customer->bill_cycle,
            'internet_fee' => $customer->internet_fee,
            'internet_quantity' => $customer->internet_quantity,
            'installation_fee' => $customer->installation_fee,
            'installation_quantity' => $customer->install_quantity,
            'number_of_invoices' => $customer->number_of_invoices,
            'ip_fee' => $customer->ip_fee,
            'ip_quantity' => $ip_quantity, // ✅ counted from ip_addresses table
        ]);
    }


    public function viewInvoice($invoiceId)
    {
        // Retrieve invoice details along with related customer and tariff
        $invoice = Invoice::with(['customer'])->findOrFail($invoiceId);
    
        return view('invoices.view', compact('invoice'));
    }

    public function print($id)
    {
        $invoice = Invoice::with('customer')->findOrFail($id);
        return view('invoices.print', compact('invoice'));
    }
    //     public function downloadAllInvoicesAsZip(Request $request)
    // {
    //     ini_set('memory_limit', '1G');
    //     set_time_limit(1800); // 30 minutes

    //     // Filter invoices
    //     $query = Invoice::query();
    //     if ($request->filled('province')) {
    //         $query->whereHas('customer', function ($q) use ($request) {
    //             $q->where('province', $request->province);
    //         });
    //     }
    //     // if ($request->filled('start_date')) {
    //     //     $query->whereDate('created_at', '>=', $request->start_date);
    //     // }
    //     // if ($request->filled('end_date')) {
    //     //     $query->whereDate('created_at', '<=', $request->end_date);
    //     // }

    //     $invoices = $query->get();

    //     if ($invoices->isEmpty()) {
    //         return response()->json(['error' => 'No invoices found for the selected criteria.'], 404);
    //     }

    //     // ZIP file path
    //     $zipFileName = "invoices_" . date('Ymd_His') . ".zip";
    //     $zipFilePath = storage_path("app/temp/$zipFileName");

    //     // Make sure temp folder exists
    //     $tempFolder = storage_path("app/temp");
    //     if (!file_exists($tempFolder)) {
    //         mkdir($tempFolder, 0777, true);
    //     }

    //     $zip = new ZipArchive;
    //     if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    //         foreach ($invoices as $invoice) {
    //             try {
    //                 $html = View::make('invoices.print', ['invoice' => $invoice])->render();

    //                 $pdfContent = Browsershot::html($html)
    //                     ->format('A4')
    //                     ->margins(10, 10, 10, 10)
    //                     ->waitUntilNetworkIdle()
    //                     ->showBackground()
    //                     ->pdf(); // Get content instead of saving to disk

    //                 $fileName = 'invoice_' . str_pad($invoice->invoice_id, 6, '0', STR_PAD_LEFT) . '.pdf';
    //                 $zip->addFromString($fileName, $pdfContent);
    //             } catch (\Exception $e) {
    //                 Log::error("Failed to generate PDF for invoice {$invoice->invoice_id}: " . $e->getMessage());
    //                 continue;
    //             }
    //         }
    //         $zip->close();
    //     } else {
    //         return response()->json(['error' => 'Failed to create ZIP file.'], 500);
    //     }

    //     return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    // }




}
