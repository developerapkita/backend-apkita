<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'contribution_id',
        'user_id',
        'month_date',
        'ammount',
        'paid_at',
        'status',
    ];
}
