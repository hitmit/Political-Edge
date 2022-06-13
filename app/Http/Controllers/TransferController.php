<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth()->user()->id;
        $transfers = Transfer::where('sender_id',$user_id)->paginate(10);

        return view('transfer.index',compact('transfers'));
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->whereNotIn('role', ['admin', 'employee'])->get();
        return view('transfer.create',compact('users'));
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
            'receiver_id'=>'required',
            'amount_send'=>'required',
        ]);

        $transfer = new Transfer();
        $transfer->fill($request->all());
        $transfer->sender_id = auth()->getUser()->id;
        $transfer->save();

        return redirect()->route('transfer.index')->withMessage("Amount Transfered sucessfully!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transfer = Transfer::find($id);
        $transfer->delete();
        return redirect()->back()->with("status", "Transfer delete successfully");
    }
}
