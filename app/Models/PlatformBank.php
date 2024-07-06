<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformBank extends Model
{
    use HasFactory;
    protected $fillable =[
        'bank_name',
        'account_name',
        'account_number'
    ];
}
