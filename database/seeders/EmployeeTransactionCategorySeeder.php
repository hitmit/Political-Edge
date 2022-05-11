<?php

namespace Database\Seeders;

use App\Models\EmployeeTransactionCategory;
use Illuminate\Database\Seeder;

class EmployeeTransactionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorys = [
            'Local Fare',
            'Room Rent',
            'Room Expense',
            'Mobile',
            'Xerox / Print',
            'Courier',
            'Outstation Travel',
            'Misc'
        ];
        foreach ($categorys as $category) {
            EmployeeTransactionCategory::create([
                "category" => $category,
            ]);
        }
    }
}
