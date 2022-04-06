<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Transaction;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'Desc')->get();
        $total_expense = Transaction::where('type', 'expense')->sum('amount');
        $total_expected_revenue = Project::sum('expected_revenue');
        $total_income = Transaction::where('type', 'income')->sum('amount');
        if (auth()->getUser()->is_admin) {
            $users = User::orderBy('created_at', 'Desc')->get();
        } else {
            $users = User::where('id', auth()->getUser()->id)->get();
        }
        return view('dashboard.index', compact('projects', 'users', 'total_expense', 'total_income', "total_expected_revenue"));
    }

    public function getUpdatePassword()
    {
        return view("users.update-password");
    }

    public function setUpdatePassword(Request $request)
    {
        $this->validate($request, [
           "old_password" => ['required', new MatchOldPassword], 
           "password" => "required|string|min:8|confirmed", 
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
        return redirect()->route("get.update.password")->withMessage("Password change successfully.");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProject($id)
    {
        $project = Project::find($id);
        return view('projects.show', compact('project'));
    }
}
