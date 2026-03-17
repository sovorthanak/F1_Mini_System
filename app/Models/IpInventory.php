<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class IpInventory extends Model
{
    protected $table = 'ip_inventory';

    protected $fillable = [
        'ip_pool_id','ip_address','customer_id','status','created_by','updated_by', 'note'
    ];

    public function pool()
    {
        return $this->belongsTo(IpPool::class, 'ip_pool_id');
    }

    protected static function booted()
    {
        static::creating(function ($ipInventory) {
            if (Auth::check()) {
                $ipInventory->created_by = Auth::user()->name;
                $ipInventory->updated_by = Auth::user()->name;
            }
        });

        static::updating(function ($ipInventory) {
            if (Auth::check()) {
                $ipInventory->updated_by = Auth::user()->name;
            }
        });
    }
}