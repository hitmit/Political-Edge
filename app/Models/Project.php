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
}
