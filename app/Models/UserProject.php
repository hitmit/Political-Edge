<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    use HasFactory;
    protected $table = 'assign_projects';
    protected $fillable = ['project_id', 'user_id'];
    public $timestamps = false;

    
}
