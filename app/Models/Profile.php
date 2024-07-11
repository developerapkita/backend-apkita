<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nik',
        'address',
        'province',
        'regencies',
        'district',
        'gender',
        'birth_date',
        'image',
        'is_verified',
        'verified_at',
        'saldo',
        'referal_code',
        'referal_code_inviter',
        'commision_at',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
