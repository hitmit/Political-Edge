<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'units',
        'employee_id',
        'advance',
        'expense',
        'project_id',
        'date'
    ];
}
