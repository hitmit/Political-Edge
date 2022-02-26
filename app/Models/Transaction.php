<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(\App\Model\Project::class, 'project_id');
    }
}
