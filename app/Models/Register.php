<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Register extends Model
{
    use HasFactory;

    protected $table = 'customers_info';
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone_number',
        'identity_doc',
        'pppoe',
        'password',
        'router',
        'province',
        'address_line_1',
        'currency',
        'first_start_date',
        'start_date',
        'internet_fee',
        'ip_fee',
        'ip_quantity',
        'bill_cycle',
        'alt_customer_name',
        'lat_long',
        'alt_address_line_1',
        'agent',
        'tariff_name',
        'bandwidth',
        'installation_fee',
        'complete_date',
        'remark',
        'status',
        'last_updated',
        'update_attempts',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'update_attempts'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'complete_date' => 'date',
        'last_updated' => 'datetime',
        'internet_fee' => 'decimal:2',
        'install_fee' => 'decimal:2',
        'ip_fee' => 'decimal:2',
        'bill_cycle' => 'integer',
        'internet_quantity' => 'integer',
        'ip_quantity' => 'integer',
        'update_attempts' => 'integer',
        'number_of_invoices' => 'integer'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'complete_date',
        'last_updated'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'name');
    }

    public function ipInventory()
    {
        return $this->hasMany(IpInventory::class, 'customer_id', 'customer_id');
    }
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            $customer->created_by = Auth::check() ? Auth::user()->name : 'Unknown';
            $customer->last_updated = now();
            $customer->update_attempts = 0;

            if ($customer->bill_cycle && $customer->start_date) {
                $startDate = Carbon::parse($customer->start_date);
                $startDay = $startDate->day;

                // Add bill_cycle months without overflowing the day
                $endDate = $startDate->copy()->addMonthsNoOverflow($customer->bill_cycle);

                // Get last day of the target month
                $lastDay = $endDate->daysInMonth;

                // Set day to start_day, or last day of target month if invalid
                $targetDay = min($startDay, $lastDay);
                $endDate->day($targetDay);

                $customer->end_date = $endDate->toDateString();
                $customer->complete_date = $endDate->copy()->subDay()->toDateString();
            }
        });

        static::updating(function ($customer) {
            $customer->updated_by = Auth::check() ? Auth::user()->name : 'Unknown';
            $customer->last_updated = now();
            $customer->update_attempts = $customer->update_attempts + 1;

            if ($customer->isDirty('bill_cycle') || $customer->isDirty('start_date')) {
                $startDate = Carbon::parse($customer->start_date);
                $startDay = $startDate->day;

                // Add bill_cycle months without overflowing the day
                $endDate = $startDate->copy()->addMonthsNoOverflow($customer->bill_cycle);

                // Get last day of the target month
                $lastDay = $endDate->daysInMonth;

                // Set day to start_day, or last day of target month if invalid
                $targetDay = min($startDay, $lastDay);
                $endDate->day($targetDay);

                $customer->end_date = $endDate->toDateString();
                $customer->complete_date = $endDate->copy()->subDay()->toDateString();
            }
        });
    }

}
?>