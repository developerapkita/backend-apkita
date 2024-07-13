<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_code',
        'name_community',
        'image',
        'description',
        'address',
        'balance',
    ];

    public function userCommunity() : HasMany
    {
         return $this->hasMany(UserCommunity::class, 'community_id');
    }

}
