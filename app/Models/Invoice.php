<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id'; // Custom primary key
    public $incrementing = false; // Since it's a string (like INV001)
    protected $keyType = 'string';

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'customer_name',
        'address_line_1',
        'alt_customer_name',
        'alt_address_line_1',
        'tariff_name',
        'bandwidth',
        'internet_fee',
        'bill_cycle',
        'installation_or_not',
        'installation_fee',
        'installation_quantity',
        'ip_fee',
        'ip_quantity',
        'total_amount',
        'payment_status',
        'payment_date',
        'start_date',
        'end_date',
        'last_updated',
        'update_attempts',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($invoice) {
            // Generate custom invoice ID
            $lastInvoice = self::latest('invoice_id')->first();
            if ($lastInvoice) {
                $lastNumber = (int) substr($lastInvoice->invoice_id, 3);
                $invoice->invoice_id = 'INV' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $invoice->invoice_id = 'INV0001';
            }
    
            // Metadata tracking
            $invoice->created_by = Auth::check() ? Auth::user()->name : 'Unknown';
            $invoice->last_updated = now();
            $invoice->update_attempts = 0;
        });
    
        static::updating(function ($invoice) {
            $invoice->updated_by = Auth::check() ? Auth::user()->name : 'Unknown';
            $invoice->last_updated = now();
            $invoice->update_attempts = $invoice->update_attempts + 1;
        });
    }


    // Define the relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Register::class, 'customer_id');
    }

}
