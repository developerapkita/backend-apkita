<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceCommunity extends Model
{
    use HasFactory;
    protected $fillable =[
        'community_id',
        'debit',
        'credit',
        'balance',
    ];
    
}
