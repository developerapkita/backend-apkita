<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoll extends Model
{
    use HasFactory;
    protected $fillable =[
        'poll_id',
        'user_id',
        'answer',
    ];
}
