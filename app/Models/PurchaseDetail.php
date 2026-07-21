<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; 

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    // relationship
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}