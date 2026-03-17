<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IpPool extends Model
{
    protected $fillable = [
        'name',
        'cidr',
        'is_active',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($ipPool) {
            if (Auth::check()) {
                $ipPool->created_by = Auth::user()->name;
                $ipPool->updated_by = Auth::user()->name;
            }
        });

        static::updating(function ($ipPool) {
            if (Auth::check()) {
                $ipPool->updated_by = Auth::user()->name;
            }
        });
    }

    public function inventory()
    {
        return $this->hasMany(IpInventory::class, 'ip_pool_id');
    }
}

