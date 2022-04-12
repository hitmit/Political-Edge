<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\TransferAmount;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
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

        // get value of A1
        $a1_of_90 = Transaction::where(['user_id' => 6, 'type' => 'income'])->sum('amount');
        $a2_of_90 = Transaction::where('user_id', '!=', 6)->where('type', 'income')->sum('amount');

        // 90% of total received account
        $a1 = ($a1_of_90 * 90) / 100;
        // 90% of total all other user
        $a2 = ($a2_of_90 * 90) / 100;
        // sum of above 2
        $a3 = ($a1 + $a2); // 1443585.24
        // dd($a3);

        // B1 Total expense by account
        $b1 = Transaction::where(['user_id' => 6, 'type' => 'expense'])->sum('amount');

        // B2 Total Expense of other user account
        $b2 = Transaction::where('user_id', '!=', 6)->where('type', 'expense')->sum('amount');

        // Sum of above 2
        $b3 = $b1 + $b2;

        // diffrence of A1 and B1
        $c1 = $a1 - $b1;
        // diffrence of A2 and B2
        $c2 = $a2 - $b2;
        // diffrence of A3 and B3
        $c3 = $a3 - $b3;


        /**
         * amount transfer
        */
        
        $total_amount_reduce = Transfer::where('sender_id',Auth()->user()->id)->sum('amount_send');
        $receiver_id = Transfer::select('receiver_id','amount_send')->get()->toArray();

        if (auth()->getUser()->is_admin) {
            $users = User::orderBy('created_at', 'Desc')->get();
        } else {
            $users = User::where('id', auth()->getUser()->id)->get();
        }
        return view('dashboard.index', compact('projects', 'users', 'total_expense', 'total_income', "total_expected_revenue", "a3", "b3", "c3","total_amount_reduce","receiver_id"));
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

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
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
