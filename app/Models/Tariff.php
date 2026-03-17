<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    // Table name (optional if it matches Laravel's plural naming)
    protected $table = 'tariffs';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    // Cast status to boolean
    protected $casts = [
        'status' => 'boolean',
    ];
}
