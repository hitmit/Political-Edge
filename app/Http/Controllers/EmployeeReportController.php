<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTransaction;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use CreateAssignProjectsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EmployeeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::where('role', 'employee')->pluck('id')->toArray();
        $projects = [];
        foreach ($employees as $employee) {
            $assign_project = UserProject::where('user_id', $employee)->pluck('project_id')->toArray();
            $projects[$employee] = Project::whereIn('id', $assign_project)->orderBy('id', 'DESC')->get();
        }
        return view('employee_report.index', compact('projects'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserProject::where('project_id', $id)->delete();
        return Redirect()->back()->with('status', 'Project remove from user');
    }

    public function show($user_id, $project_id)
    {
        $project = Project::where('id', $project_id)->orderBy('created_at', 'Desc')->first();
        $progress = EmployeeTransaction::where('employee_id', $user_id)->where('project_id', $project_id)->where('type', '=', null)->get();
        $incomes = EmployeeTransaction::where('employee_id', $user_id)->where('project_id', $project_id)->where('type', 'income')->get();
        $expenses = EmployeeTransaction::where('employee_id', $user_id)->where('project_id', $project_id)->where('type', 'expense')->get();
        
        $employee_total_expense = EmployeeTransaction::where('employee_id', $user_id)->where('type', 'expense')->where('project_id', $project_id)->sum('amount');
        $employee_total_advance = EmployeeTransaction::where('employee_id', $user_id)->where('type', 'income')->where('project_id', $project_id)->sum('amount');
        $employee_total_progress = EmployeeTransaction::where('employee_id', $user_id)->where('project_id', $project_id)->sum('units');

        return view('employee_report.show', compact('project', 'incomes', 'expenses', 'progress', 'employee_total_expense', 'employee_total_advance', 'employee_total_progress'));
    }
}
