<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class UnpaidInvoicecontroller extends Controller
{
    public function index()
    {
        // Get all invoices
        $invoices = Invoice::with('customer')->get()->where('payment_status', 'Unpaid');
        
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
        return view('unpaid_invoice.index', compact('invoices', 'total_invoices', 'total_amount', 'total_paid', 'total_unpaid', 'total_paid_invoices', 'total_unpaid_invoices'));
    }
    
    public function updatePaymentStatus($invoiceId)
    {
        try {
            $invoice = Invoice::findOrFail($invoiceId);
            $invoice->payment_status = 'Paid';
            $invoice->payment_date = today(); // Set payment date to current date and time
            $invoice->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Payment status and date updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
