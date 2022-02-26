<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view("users.manage-user", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:11|numeric',
            'name' => 'required|max:120',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect(route("users.index"))->with("status", "User added successfully");
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
        return view("users.edit", array("user" => $user));
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
            'email' => 'required|email',
            'phone' => 'required|min:11|numeric',
            'name' => 'required|max:120',
        ];
        $account = User::find($id);
        if ($account->email != $request->email) {
            $rules['email'] = 'required|email|unique:users,email';
        }
        if ($request->password) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        $this->validate($request, $rules);
        $account->fill($request->all());
        $account->save();
        return redirect(route("users.index"))->with("status", "User added successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
