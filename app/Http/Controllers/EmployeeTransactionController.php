<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTransaction;
use App\Models\EmployeeTransactionCategory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Rules\EmployeeProgress;

class EmployeeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function project_detail($project_id)
    {
        $progress = EmployeeTransaction::where('project_id', $project_id)->where('type', '=', null)->get();
        $expenses = EmployeeTransaction::where('project_id', $project_id)->where('type', 'expense')->get();
        $incomes = EmployeeTransaction::where('project_id', $project_id)->where('type', 'income')->get();
        $categories = EmployeeTransactionCategory::all();
        $project = Project::find($project_id);
        $users = User::where('role', 'user')->get();

        /**
         * total expense of employee
         * @return sum of expense
         */
        $employee_total_expense = EmployeeTransaction::where('employee_id', Auth()->user()->id)->where('type', 'expense')->where('project_id', $project_id)->sum('amount');

        return view('units.index', compact('expenses', 'incomes', 'progress', 'project_id', 'project', 'categories', 'users', 'employee_total_expense'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
        ]);
        if (!empty($request->progress)) {
            $request->validate([
                'progress' => [new EmployeeProgress($request->project_id)],
            ]);
        }

        if (!empty($request->expense_amount)) {
            $category_ids = $request->category_id;
            $expense_amount = $request->expense_amount;
            foreach ($category_ids as $key => $category_id) {
                $employee_transaction = new EmployeeTransaction();
                $employee_transaction->category_id = $category_id;
                $employee_transaction->project_id = $request->project_id;
                $employee_transaction->type = "expense";
                $employee_transaction->date = $request->date;
                $employee_transaction->amount = $expense_amount[$key];
                $employee_transaction->employee_id = Auth()->user()->id;
                $employee_transaction->save();
            }
        }
        if (!empty($request->amount_income)) {
            $employee_transaction = new EmployeeTransaction();
            $employee_transaction->user_id = $request->user_id;
            $employee_transaction->type = "income";
            $employee_transaction->date = $request->date;
            $employee_transaction->amount = $request->amount_income;
            $employee_transaction->project_id = $request->project_id;
            $employee_transaction->employee_id = Auth()->user()->id;
            $employee_transaction->save();
        }


        if (!empty($request->progress)) {
            $employee_transactions = new EmployeeTransaction();
            $employee_transactions->units = $request->progress;
            $employee_transactions->project_id = $request->project_id;
            $employee_transactions->date = $request->date;
            $employee_transactions->employee_id = Auth()->user()->id;
            $employee_transactions->save();
        }
        return redirect()->route('project.details', $request->project_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
        return Redirect::back()->with("status", "Progress deleted successfully");
    }
}
