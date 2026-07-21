<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $table = 'tbl_chart_of_accounts';

    protected $fillable = [
        'head_code',
        'head_name',
        'parent_id',
        'level',
        'supplier_id',
        'customer_id'
    ];
}