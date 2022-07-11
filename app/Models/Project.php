<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    public function transections()
    {
        return $this->hasMany(Transaction::class);
    }

    public function employee_transactions($user_id)
    {
        return EmployeeTransaction::where('project_id', $this->id)->where('employee_id', $user_id)->sum('units');
    }
    public function advance_total($user_id)
    {
        return EmployeeTransaction::where('project_id', $this->id)->where('employee_id', $user_id)->where('type', 'income')->sum('amount');
    }
    public function expense_total($user_id)
    {
        return EmployeeTransaction::where('project_id', $this->id)->where('employee_id', $user_id)->where('type', 'expense')->sum('amount');
    }
    public function getUSer($user_id)
    {
        return User::where('role', 'employee')->where('id', $user_id)->first()->name;
    }
}
