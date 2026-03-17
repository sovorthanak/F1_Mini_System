<?php

use App\Models\Register;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Carbon;

Schedule::command('notify:pending-requests')
    ->dailyAt('08:00');

Schedule::call(function () {
    try {
        Log::channel('custom_schedule')->info('🕐 Scheduler started at ' . now());
    
        $currentDate = Carbon::today()->toDateString();
    
        // Fetch active customers with start_date <= today
        $customers = Register::whereDate('start_date', '<=', $currentDate)
            ->where('status', 'Active')
            ->with('ipAddresses') // eager load IPs
            ->get();
    
        $invoiceCount = 0;
    
        foreach ($customers as $customer) {
            $invoiceExists = $customer->invoices()
                ->whereDate('start_date', $customer->start_date)
                ->exists();
    
            if (!$invoiceExists) {
                $number_of_invoices = $customer->number_of_invoices ?? 0;
                $installation_fee = $customer->installation_fee ?? 0;
                $internet_fee = $customer->internet_fee ?? 0;
                $ip_fee = $customer->ip_fee ?? 0;
    
                // ✅ Count IPs using relation
                $ip_quantity = $customer->ipAddresses->count();
    
                $bill_cycle = $customer->bill_cycle ?? 1;
    
                $installation_or_not = ($number_of_invoices != 0 || $installation_fee == 0) ? 'false' : 'true';
                $include_installation_fee = $installation_or_not === 'true' ? round($installation_fee, 2) : 0.00;
    
                $internet_fee_total = round($internet_fee, 2);
                $ip_total = round($ip_fee * $ip_quantity, 2);
                $total_amount = round($internet_fee_total + $ip_total + $include_installation_fee, 2);
    
                // Create invoice via Eloquent
                $customer->invoices()->create([
                    'customer_name' => $customer->customer_name,
                    'address_line_1' => $customer->address_line_1,
                    'alt_customer_name' => $customer->alt_customer_name ?? '',
                    'alt_address_line_1' => $customer->alt_address_line_1 ?? '',
                    'tariff_name' => $customer->tariff_name ?? '',
                    'bandwidth' => $customer->bandwidth ?? '',
                    'internet_fee' => $internet_fee,
                    'ip_fee' => $ip_fee,
                    'ip_quantity' => $ip_quantity, // ✅ from ip_addresses relation
                    'installation_fee' => $installation_fee,
                    'payment_status' => 'Unpaid',
                    'start_date' => $customer->start_date,
                    'end_date' => $customer->end_date,
                    'bill_cycle' => $bill_cycle,
                    'installation_or_not' => $installation_or_not,
                    'total_amount' => $total_amount,
                    'created_by' => 'Auto Generated',
                ]);
    
                // Update customer
                $customer->update([
                    'number_of_invoices' => $number_of_invoices + 1,
                    'start_date' => $customer->end_date,
                    'end_date' => Carbon::parse($customer->end_date)->addMonths($bill_cycle)->toDateString(),
                ]);
    
                $invoiceCount++;
                Log::channel('custom_schedule')->info("✅ Invoice created for customer ID: {$customer->customer_id} with {$ip_quantity} IP(s).");
            }
        }
    
        if ($invoiceCount > 0) {
            Log::channel('custom_schedule')->info("🎉 Total invoices generated for {$currentDate}: {$invoiceCount}");
        } else {
            Log::channel('custom_schedule')->info("ℹ️ No invoices generated for {$currentDate}");
        }
    
        Log::channel('custom_schedule')->info('✅ Scheduler completed at ' . now());
    
    } catch (\Throwable $e) {
        Log::channel('custom_schedule')->error('❌ Scheduled task failed: ' . $e->getMessage());
    }
})->twiceDaily(8, 14);

Schedule::exec('/bin/bash /home/fastoneisp/backup-scripts/laravel_backup.sh')
    ->dailyAt('16:00')
    ->withoutOverlapping()
    ->appendOutputTo('/home/fastoneisp/backups/laravel/backup_scheduler.log');

