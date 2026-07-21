<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_chart_of_accounts')->insert([
            ['id' => 1, 'head_code' => '1001', 'head_name' => 'Assets', 'parent_id' => null, 'level' => 0],
            ['id' => 2, 'head_code' => '2001', 'head_name' => 'Liabilities', 'parent_id' => null, 'level' => 0],
            ['id' => 3, 'head_code' => '3001', 'head_name' => 'Cash In Hand', 'parent_id' => 1, 'level' => 1],
            ['id' => 4, 'head_code' => '4001', 'head_name' => 'Inventory', 'parent_id' => 1, 'level' => 1],
            ['id' => 5, 'head_code' => '5001', 'head_name' => 'Expenses', 'parent_id' => 1, 'level' => 1],
            ['id' => 6, 'head_code' => '6001', 'head_name' => 'Receivables', 'parent_id' => 1, 'level' => 1],
            ['id' => 7, 'head_code' => '7001', 'head_name' => 'Salaries Payable', 'parent_id' => 2, 'level' => 1],
            ['id' => 8, 'head_code' => '8001', 'head_name' => 'Capital', 'parent_id' => 2, 'level' => 1],
            ['id' => 9, 'head_code' => '9001', 'head_name' => 'Payables', 'parent_id' => 2, 'level' => 1],
            ['id' => 10, 'head_code' => '1101', 'head_name' => 'Income', 'parent_id' => 2, 'level' => 1],
            ['id' => 11, 'head_code' => '1201', 'head_name' => 'Salaries Expense', 'parent_id' => 1, 'level' => 1],
            ['id' => 12, 'head_code' => '1301', 'head_name' => 'Dividend Payables', 'parent_id' => 2, 'level' => 1],
            ['id' => 13, 'head_code' => '1401', 'head_name' => 'Rent Receivables', 'parent_id' => 1, 'level' => 1],
            ['id' => 14, 'head_code' => '1501', 'head_name' => 'Profit & Loss', 'parent_id' => 2, 'level' => 1],
            ['id' => 15, 'head_code' => '1601', 'head_name' => 'Rent Revenue', 'parent_id' => 2, 'level' => 1],
            ['id' => 16, 'head_code' => '1701', 'head_name' => 'Other Revenue', 'parent_id' => 2, 'level' => 1],
            ['id' => 17, 'head_code' => '1801', 'head_name' => 'PPE Receivables', 'parent_id' => 1, 'level' => 1],
            ['id' => 18, 'head_code' => '1901', 'head_name' => 'Other Receivables', 'parent_id' => 1, 'level' => 1],
            ['id' => 19, 'head_code' => '2101', 'head_name' => 'Other Payables', 'parent_id' => 2, 'level' => 1],
            ['id' => 20, 'head_code' => '2201', 'head_name' => 'Bank', 'parent_id' => 1, 'level' => 1],
            ['id' => 21, 'head_code' => '2301', 'head_name' => 'Other', 'parent_id' => null, 'level' => 0],
        ]);
    }
}