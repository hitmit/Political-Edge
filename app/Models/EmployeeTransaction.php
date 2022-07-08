<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTransaction extends Model
{
    use HasFactory;
    protected $table = 'employee_transactions';
    protected $fillable = [
        'units',
        'employee_id',
        'type',
        'amount',
        'project_id',
        'date'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee_category()
    {
        return $this->belongsTo(EmployeeTransactionCategory::class , 'category_id');
    }
}
