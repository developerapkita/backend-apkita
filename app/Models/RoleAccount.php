<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccount extends Model
{
    use HasFactory;
    protected $fillable =[
        'role_name',
    ];
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
