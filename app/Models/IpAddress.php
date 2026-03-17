<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use HasFactory;

    protected $table = 'ip_addresses';

    public $timestamps = false;


    protected $fillable = [
        'customer_id',
        'ip_address',
        'position',
        'created_by',
        'last_updated',
        'update_attempts',
        'created_by',
        'updated_by',
    ];

    // Relationship: an IP belongs to a Customer
    public function customer()
    {
        return $this->belongsTo(Register::class, 'customer_id', 'customer_id');
    }

    protected static function booted()
    {
        static::saving(function ($ip) {
            if ($ip->exists) {
                // Updating
                $ip->last_updated = now();
                $ip->update_attempts = ($ip->update_attempts ?? 0) + 1;
                $ip->updated_by = Auth::check() ? Auth::user()->name : 'System';
            } else {
                // Creating
                $ip->created_by = Auth::check() ? Auth::user()->name : 'System';
                $ip->update_attempts = 0; // initialize
            }
        });
    }


}
