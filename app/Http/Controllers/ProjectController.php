<?php

namespace App\Http\Controllers;

use App\Models\AssignProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);
        return view('projects.manage-project', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth()->user()->id)->get();
        return view('projects.add-project', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => 'required',
            'expected_revenue' => "required",
        ]);
        $project = new Project;
        $project->name = $request->name;
        $project->expected_revenue = $request->expected_revenue;
        $project->save();

        foreach ($request->users as $user) {
            $assign_projects  = new AssignProject();
            $assign_projects->user_id = $user;
            $assign_projects->project_id = $project->id;
            $assign_projects->save();
        }

        return redirect(route("project.index"))->with("status", "Project added successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $project = Project::find($id);
        $users = User::where('id', '!=', Auth()->user()->id)->get();
        $users_check = AssignProject::where('project_id', $id)->pluck('user_id')->toArray();

        return view("projects.edit", compact('project', 'users', 'users_check'));
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
        $this->validate($request, [
            "name" => 'required',
            'expected_revenue' => "required",
        ]);

        Project::where('id', $request->id)->update([
            'name' => $request->name,
            'expected_revenue' => $request->expected_revenue,
        ]);
        AssignProject::where('project_id', $id)->delete();
        if ($request->users != null) {
            foreach ($request->users as $user) {
                $assign_projects  = new AssignProject();
                $assign_projects->user_id = $user;
                $assign_projects->project_id = $id;
                $assign_projects->save();
            }
        }
        return redirect(route("project.index"))->with("status", "Project updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if ($project->transections()->count()) {
            return Redirect::back()->with("error", "Project hsa income and expense associated so it can't be deleted.");
        } else {
            $project->delete();
            return Redirect::back()->with("status", "Project delete successfully");
        }
    }
}
