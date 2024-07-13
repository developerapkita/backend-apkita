<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCommunity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'inviter_id',
        'community_id',
        'role',
        'is_owner',
        'is_accept',
        'responded_at'
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id','inviter_id');
    }
    public function community():BelongsTo
    {
        return $this->belongsTo(User::class, 'communnity_id');
    }
    
}
