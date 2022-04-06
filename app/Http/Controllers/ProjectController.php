<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
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
        return view('projects.add-project');
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
        return view("projects.edit", compact('project'));
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
