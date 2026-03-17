<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RequestChange extends Model
{
    use HasFactory;

    protected $table = 'request_change';

    protected $fillable = [
        'request_type',
        'customer_id',

        'old_customer_name',
        'old_tariff',
        'old_bandwidth',
        'old_internet_fee',
        'old_address',
        'old_alt_address',
        'old_ip_address',
        'old_province',
        'old_pppoe',
        'old_pw',
        'old_router',
        'old_customer_status',
        'old_remark',

        'new_customer_name',
        'new_tariff',
        'new_bandwidth',
        'new_internet_fee',
        'new_address',
        'new_alt_address',
        'new_ip_address',
        'new_province',
        'new_pppoe',
        'new_pw',
        'new_router',
        'new_customer_status',
        'new_remark',

        'date',
        'status',
        'created_by',
        'completed_by',
    ];

    // Let Laravel handle timestamps automatically
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($requestChange) {
            $requestChange->created_by = Auth::check() ? Auth::user()->name : null;
            // no need to set created_at manually if timestamps = true
        });
    }

    public function customer()
    {
        return $this->belongsTo(Register::class, 'customer_id', 'customer_id');
    }
}

