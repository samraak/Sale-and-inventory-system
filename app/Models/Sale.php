<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{   
    // Product_id yahan nahi honi chahiye, sahi kiya aapne
    protected $fillable = ['date', 'total_amount', 'customer_id', 'voucher_no'];

    // Customer ke sath rabta
    public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function details()
{
    return $this->hasMany(SaleDetail::class);
}
}