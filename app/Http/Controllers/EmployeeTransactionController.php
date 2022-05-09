<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTransaction;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmployeeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function project_detail($project_id)
    {
        $employee_transactions = EmployeeTransaction::where('project_id', $project_id)->paginate(10);
        return view('units.index', compact('employee_transactions', 'project_id'));
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
        $request->validate(['date' => 'required']);
        $project_unit = Project::where('id', $request->project_id)->value('units');
        if (!$project_unit) {
            return redirect()->back()->with('status', 'Your progress couldn\'t be saved');
        }
        $employee_transactions = new EmployeeTransaction();
        $employee_transactions->units = $request->progress;
        $employee_transactions->advance = $request->advance;
        $employee_transactions->expense = $request->expense;
        $employee_transactions->project_id = $request->project_id;
        $employee_transactions->date = $request->date;
        $employee_transactions->employee_id = Auth()->user()->id;
        $employee_transactions->save();
        return redirect()->back()->with('status', 'Progress added successfully!!');
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
