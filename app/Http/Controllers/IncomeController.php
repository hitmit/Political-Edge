<?php

namespace App\Http\Controllers;

use App\Models\ExpenseModel;
use App\Models\IncomeModel;
use App\Models\ProjectModel;
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
        $incomes = ExpenseModel::where(['type' => 'income', "user_id" => Auth::user()->id])->paginate(4);
        return view("income.manage-income", compact("incomes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = ProjectModel::all();
        return view("income.add-income", compact("projects"));
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
            "amt" => "required"
        ]);

        $income = new ExpenseModel;

        $income->date = $request->date;
        $income->time = $request->time;
        $income->remark = $request->remark;
        $income->project_id = $request->project;
        $income->amount = $request->amt;
        $income->user_id = Auth::user()->id;
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
        $incomes = ExpenseModel::find($id);
        $projects = ProjectModel::all();
        return view("income.edit", array(
            "income" => $incomes,
            "projects" => $projects
        ));
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
            "amt" => "required"
        ]);

        ExpenseModel::where(["id" => $id, "type" => "income", 'user_id' => Auth::user()->id])->update([
            "date" => $request->date,
            "time" => $request->time,
            "remark" => $request->remark,
            "project_id" => $request->project,
            "amount" => $request->amt
        ]);

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
        ExpenseModel::where(['id' => $id, 'type' => 'income', 'user_id' => Auth::user()->id])->delete();
        return Redirect::back()->with("status", "Project delete successfully");
    }
}
