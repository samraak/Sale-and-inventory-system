<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','quantity', 'supplier_id', 'unit_id', 'status'];

// Supplier ke sath taluq
public function supplier() {
    return $this->belongsTo(Supplier::class);
}

// Unit ke sath taluq
public function unit() {
    return $this->belongsTo(Unit::class);
}
}