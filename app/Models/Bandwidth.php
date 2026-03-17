<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bandwidth extends Model
{
    protected $fillable = ['speed', 'description', 'status'];
}

