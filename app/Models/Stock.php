<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'unit_price',
        'purchase_id',
        'purchasedetail_id',
        'date',
        'updated_stock',
        'supplier_id',
        'process',       // 'PURCHASE' ya 'SALE'
        'sale_id',       // SALE process ke liye
        'shippment_id',  // SALE process ke liye - kaunse purchase stock se aaya
    ];

    // ==================== RELATIONSHIPS ====================

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class, 'purchasedetail_id');
    }

    // ==================== SCOPES ====================

    // Sirf purchase entries
    public function scopePurchases($query)
    {
        return $query->where('process', 'PURCHASE');
    }

    // Sirf sale entries
    public function scopeSales($query)
    {
        return $query->where('process', 'SALE');
    }

    // Available stock (PURCHASE entries jinka updated_stock > 0)
    public function scopeAvailable($query)
    {
        return $query->where('process', 'PURCHASE')
                     ->where('updated_stock', '>', 0);
    }
}