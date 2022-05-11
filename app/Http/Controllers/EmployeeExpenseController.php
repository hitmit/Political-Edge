<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EmployeeExpenseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_expense' => 'required',
            'amount' => 'required',
            'category' => 'required',
            'project_id' => 'required',
        ], [
            'date_expense.required' => 'The date field is required.',
        ]);

        $employee_transactions = new EmployeeTransaction();
        $employee_transactions->category_id = $request->category;
        $employee_transactions->date = $request->date_expense;
        $employee_transactions->amount = $request->amount;
        $employee_transactions->type = 'expense';
        $employee_transactions->project_id = $request->project_id;
        $employee_transactions->employee_id = Auth()->user()->id;
        $employee_transactions->save();

        if ($employee_transactions->save()) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmployeeTransaction::where('id', $id)->delete();
        return Redirect::back()->with("status", "Expense deleted successfully");
    }
}
