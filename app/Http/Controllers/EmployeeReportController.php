<?php

namespace App\Http\Controllers;

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
        $employees = User::where('role','employee')->pluck('id')->toArray();
        $assign_project = UserProject::whereIn('user_id',$employees)->pluck('project_id')->toArray();
        $projects = Project::whereIn('id', $assign_project)->orderBy('id', 'DESC')->paginate(10);
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
}
