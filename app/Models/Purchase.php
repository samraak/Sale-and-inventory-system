<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use App\Models\Stock;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'purchase_no',
        'supplier_id',
        'narration',
        'total_amount'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}