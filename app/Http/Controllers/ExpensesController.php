<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $categorys = Category::all();
        $query = Transaction::select('transactions.*', 'users.name')->where('type', 'expense')->join('users', 'transactions.user_id', '=', 'users.id');
        $user_id = Transaction::where('type', 'expense')->pluck('user_id');
        $username = User::whereIN('id', $user_id)->get();

        if (auth()->getUser()->role != 'admin') {
            $query->where("user_id", Auth::user()->id);
        }
        if (request()->filled('category')) {
            $query->where('category_id', request()->get('category'));
        }
        if (request()->filled('user')) {
            $query->where('users.name', 'like', '%' . request()->get('user') . '%');
        }

        if (request()->filled('start_date') && !request()->filled('end_date')) {
            $query->where('date', '>=', request('start_date'));
        }
        if (request()->filled('end_date') && !request()->filled('start_date')) {
            $query->where('date', '<=', request('end_date'));
        }
        if (request()->filled('start_date') && request()->filled('end_date')) {
            $query->whereBetween('date', [request('start_date'), request('end_date')]);
        }

        $query->orderBy('created_at', 'desc');
        if (request()->filled('export')) {
            return Excel::download(new ExpenseExport($query), 'expenses.xlsx');
        }
        $expenses = $query->paginate(50);

        $categorysChart = Category::all();


        $chartLists = "";
        foreach ($categorysChart as $list) {
            $totalAmount = Transaction::where('category_id', $list->id)->where('type', 'expense')->sum('amount');
            $chartLists .= "['" . $list->name . "'," . $totalAmount . "],";
        }

        $result['chartData'] = rtrim($chartLists, ",");
        return view("expenses.manage-expenses", compact("expenses", 'categorys'), $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        $users = [];
        if (auth()->getUser()->role == 'admin') {
            $users = User::all();
        }
        $categories = Category::where("status", 1)->get();

        return view("expenses.add-expense", compact("projects", "users", "categories"));
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
            "category_id" => "required",
            // "project" => "required",
            "amount" => "required|confirmed"
        ]);

        $expense = new Transaction;

        $expense->date = $request->date;
        $expense->remark = $request->remark;
        // $expense->project_id = $request->project;
        $expense->category_id = $request->category_id;
        $expense->type = "expense";
        $expense->amount = $request->amount;
        $expense->user_id =  Auth::user()->id;
        if ($request->user_id) {
            $expense->user_id = $request->user_id;
        }
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
        $users = [];
        if (auth()->getUser()->role == 'admin') {
            $users = User::all();
        }
        $expense = Transaction::find($id);
        $projects = Project::all();
        $categories = Category::all();
        return view("expenses.edit", compact("expense", "projects", "categories"));
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
            // "project" => "required",
            "category_id" => "required",
            "amount" => "required|confirmed"
        ]);
        $transaction = Transaction::find($id);
        $transaction->date = $request->date;
        $transaction->remark = $request->remark;
        $transaction->category_id = $request->category_id;
        // $transaction->project_id = $request->project;
        $transaction->amount = $request->amount;
        if ($request->user_id) {
            $transaction->user_id = $request->user_id;
        }
        $transaction->save();

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
        Transaction::where(['id' => $id, 'type' => 'expense'])->delete();
        return Redirect::back()->with("status", "Expense delete successfully");
    }
}
