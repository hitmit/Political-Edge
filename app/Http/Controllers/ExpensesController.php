<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Transaction::where('type', 'expense');
        if (!auth()->getUser()->is_admin) {
            $query->where("user_id", Auth::user()->id);
        }
        $expenses = $query->paginate(10);
        return view("expenses.manage-expenses", compact("expenses"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        $users = [];
        if (auth()->getUser()->is_admin) {
            $users = User::all();
        }
        return view("expenses.add-expense", compact("projects", "users"));
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
            "time" => "required",
            // "remark" => "required",
            "project" => "required",
            "amount" => "required"
        ]);

        $expense = new Transaction;

        $expense->date = $request->date;
        $expense->time = $request->time;
        $expense->remark = $request->remark;
        $expense->project_id = $request->project;
        $expense->type = "expense";
        $expense->amount = $request->amount;
        $expense->user_id =  Auth::user()->id;
        if ($request->user_id) {
            $expense->user_id = $reqest->user_id;
        }
        $expense->save();
        return redirect(route("expenses.index"))->with("status", "Expenses addedd successfully");
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
        $users = [];
        if (auth()->getUser()->is_admin) {
            $users = User::all();
        }
        $expense = Transaction::find($id);
        $projects = Project::all();
        return view("expenses.edit", compact("expense", "projects"));
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
        $request->validate([
            'date' => 'required',
            "time" => "required",
            "project" => "required",
            "amount" => "required"
        ]);
        $transaction = Transaction::find($id);
        $transaction->date = $request->date;
        $transaction->time = $request->time;
        $transaction->remark = $request->remark;
        $transaction->project_id = $request->project;
        $transaction->amount = $request->amount;
        if ($request->user_id) {
            $transaction->user_id = $request->user_id;
        }
        $transaction->save();

        return redirect(route("expenses.index"))->with("status", "Expenses updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::where(['id' => $id, 'type' => 'expense', 'user_id' => Auth::user()->id])->delete();
        return Redirect::back()->with("status", "Expense delete successfully");
    }
}
