<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'transaction_type',
        'transaction_type_id',
        'voucher_no',
        'narration',
        'total_amount'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}