<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmployeeIncomeController extends Controller
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
            'date_income' => 'required',
            'amount_income' => 'required',
            'user_id' => 'required',
            'project_id' => 'required',
        ], [
            'date_income.required' => 'The date field is required.',
            'amount_income.required' => 'The income field is required.',
        ]);

        $employee_transactions = new EmployeeTransaction();
        $employee_transactions->user_id = $request->user_id;
        $employee_transactions->date = $request->date_income;
        $employee_transactions->amount = $request->amount_income;
        $employee_transactions->type = 'income';
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
        return Redirect::back()->with("status", "Income deleted successfully");
    }
}