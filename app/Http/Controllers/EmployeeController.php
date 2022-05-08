<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class EmployeeControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'employee')->paginate(10);
        return view("employee.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        return view("employee.create", compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            "email.required" => 'Username field is required',
            "email.unique" => 'Username already taken',
        ];
        $validate = $request->validate([
            'email' => 'required|unique:users,email',
            // 'phone' => 'required|min:11|numeric',
            'name' => 'required|max:120',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = 'employee';
        $user->password = Hash::make($request->password);
        $user->save();
        foreach ($request->projects as $project_id) {
            $assign_projects  = new UserProject();
            $assign_projects->user_id = $user->id;
            $assign_projects->project_id = $project_id;
            $assign_projects->save();
        }
        return redirect(route("employee.index"))->with("status", "Employee added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $projects = Project::all();
        $selected_projects = UserProject::where('user_id', $id)
            ->pluck('project_id')->toArray();
        return view("employee.edit", compact('user', 'projects', 'selected_projects'));
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
        $rules = [
            'email' => 'required',
            // 'phone' => 'required|min:11|numeric',
            'name' => 'required|max:120',
        ];
        $account = User::find($id);
        if ($account->email != $request->email) {
            $rules['email'] = 'required|unique:users,email';
        }
        if ($request->password) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        $messages = [
            "email.required" => 'Username field is required',
            "email.unique" => 'Username already taken',
        ];
        $this->validate($request, $rules, $messages);
        $account->email = $request->email;
        $account->phone = $request->phone;
        $account->name = $request->name;
        $account->role = 'employee';
        if ($request->password) {
            $account->password = Hash::make($request->password);    
        }
        $account->save();
        if ($request->projects != null) {
            UserProject::where('user_id', $account->id)->delete();
            foreach ($request->projects as $project_id) {
                $assign_projects  = new UserProject();
                $assign_projects->user_id = $user->id;
                $assign_projects->project_id = $project_id;
                $assign_projects->save();
            }
        }
        return redirect(route("employee.index"))->with("status", "Employee updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect(route("users.index"));
    }
}
