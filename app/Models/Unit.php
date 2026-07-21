<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    // This allows the Save button to actually put data in the table
    protected $fillable = ['name', 'status'];
}