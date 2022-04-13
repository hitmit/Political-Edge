<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_id',
        'amount_send',
        'receiver_id',
    ];


    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'receiver_id');
    }
}
