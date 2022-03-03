<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Transaction::where('type', 'income');
        if (!auth()->getUser()->is_admin) {
            $query->where("user_id", Auth::user()->id);
        }
        $incomes = $query->paginate(10);
        return view("income.manage-income", compact("incomes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = [];
        if (auth()->getUser()->is_admin) {
            $users = User::all();
        }
        $projects = Project::all();
        return view("income.add-income", compact("projects", "users"));
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
            // "remark" => "required",
            "project" => "required",
            "amount" => "required|confirmed"
        ]);

        $income = new Transaction;

        $income->date = $request->date;
        $income->remark = $request->remark;
        $income->project_id = $request->project;
        $income->amount = $request->amount;
        $income->user_id = Auth::user()->id;
        if ($request->user_id) {
            $income->user_id = $request->user_id;
        }
        $income->type = "income";
        $income->save();
        return redirect(route("income.index"))->with("status", "Income addedd successfully");
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
        $income = Transaction::find($id);
        $projects = Project::all();
        return view("income.edit", compact("income",
            "projects"));
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
            "project" => "required",
            "amount" => "required|confirmed"
        ]);
        $transaction = Transaction::find($id);
        $transaction->date = $request->date;
        $transaction->remark = $request->remark;
        $transaction->project_id = $request->project;
        $transaction->amount = $request->amount;
        if ($request->user_id) {
            $transaction->user_id = $request->user_id;
        }
        $transaction->save();

        return redirect(route("income.index"))->with("status", "Expenses updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::where(['id' => $id, 'type' => 'income', 'user_id' => Auth::user()->id])->delete();
        return Redirect::back()->with("status", "Income delete successfully");
    }
}
