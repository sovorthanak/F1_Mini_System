<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    protected $table = 'cases_handle';   // Updated table name
    protected $primaryKey = 'case_id';   // Custom primary key

    protected $fillable = [
        'case_type',
        'customer_id',
        'status',
        'create_date',
        'remark',
        'deadline',
        'complete_date',
        'created_by',
        'updated_by',
        'completed_by',
        'last_updated',
        'update_attempts',
    ];

    // Relationship to customer
    public function customer()
    {
        return $this->belongsTo(Register::class, 'customer_id');
    }

    // Relationship to creator (User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship to updater (User)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relationship to completer (User)
    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}