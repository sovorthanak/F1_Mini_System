<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RequestTesting extends Model
{
    use HasFactory;

    protected $table = 'request_testing';

    protected $fillable = [
        'request_type',
        'customer_id',

        'old_customer_name',
        'old_tariff',
        'old_bandwidth',
        'old_pppoe',
        'old_pw',
        'old_router',

        'new_customer_name',
        'new_tariff',
        'new_bandwidth',
        'new_pppoe',
        'new_pw',
        'new_router',

        'request_date',
        'end_testing_date',
        'remark',
        'status',
        'created_by',
        'completed_by',
    ];

    // Let Laravel handle timestamps automatically
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($requestTesting) {
            $requestTesting->created_by = Auth::check() ? Auth::user()->name : null;
            // no need to set created_at manually if timestamps = true
        });
    }

    public function customer()
    {
        return $this->belongsTo(Register::class, 'customer_id', 'customer_id');
    }
}

