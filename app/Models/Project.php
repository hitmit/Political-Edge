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

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'id');
    }
    public function employee_transactions()
    {
        return $this->hasMany(EmployeeTransaction::class);
    }
    public function advance_total()
    {
        return EmployeeTransaction::where('project_id', $this->id)->where('type', 'income')->sum('amount');
    }
    public function expense_total()
    {
        return EmployeeTransaction::where('project_id', $this->id)->where('type', 'expense')->sum('amount');
    }
    public function getusername()
    {
        $user_id = UserProject::where('project_id', $this->id)->value('user_id');
        return User::where('role','employee')->where('id',$user_id)->value('name');
    }

}
