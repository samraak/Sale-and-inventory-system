<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class TransactionDetail extends Model
{
    protected $fillable = [
        'date',
        'transaction_id',
        'head_code',
        'debit',
        'credit'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}