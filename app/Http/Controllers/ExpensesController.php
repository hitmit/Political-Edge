<?php

namespace App\Http\Controllers;

use App\Models\ExpenseModel;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Project;

class ExpensesController extends Controller
{
    /**FF
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $expenses = ExpenseModel::where(['type' => 'expense', "user_id" => Auth::user()->id])->paginate(4);
        foreach ($expenses as $expense) {
            $project_id = $expense->id;
            // dd($project_id);
        }
        return view("expenses.manage-expenses", compact(["expenses"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = ProjectModel::paginate(4);
        return view("expenses.add-expense", compact("projects"));
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

        $expense = new ExpenseModel;

        $expense->date = $request->date;
        $expense->time = $request->time;
        $expense->remark = $request->remark;
        $expense->project_id = $request->project;
        $expense->type = "expense";
        $expense->amount = $request->amt;
        $expense->user_id =  Auth::user()->id;
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
        $expenses = ExpenseModel::find($id);
        $projects = ProjectModel::all();
        return view("expenses.edit", array(
            "expense" => $expenses,
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
            // "remark" => "required",
            "project" => "required",
            "amt" => "required"
        ]);

        ExpenseModel::where(['id' => $id, 'type' => 'expense', 'user_id' => Auth::user()->id])->update([
            "date" => $request->date,
            "time" => $request->time,
            "remark" => $request->remark,
            "project_id" => $request->project,
            "amount" => $request->amt
        ]);

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
        ExpenseModel::where(['id' => $id, 'type' => 'expense', 'user_id' => Auth::user()->id])->delete();
        return Redirect::back()->with("status", "Project delete successfully");
    }
}
