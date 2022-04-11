<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpenseExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $query;
    function __construct($query)
    {
        $this->query = $query;
    }
    public function headings(): array
    {
        return [
            "Username",
            "Category",
            "Expenses",
            "Remark",
            "Date",
        ];
    }
    public function collection()
    {
        return ($this->query->get());
    }
    /**
     * @var Expenses $expenses
     */
    public function map($expenses): array
    {
        $username = "";
        $category = "";
        $user_id = $expenses->User()->first();
        $category_id = $expenses->category()->first();
        if ($user_id) {
            $username = $user_id->name;
        }
        if ($category_id) {
            $category = $category_id->name;
        }
        return [
            $username,
            $category,
            $expenses->amount,
            $expenses->remark,
            $expenses->date,
        ];
    }
}
