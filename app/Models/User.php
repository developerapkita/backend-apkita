<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'pin_transaction',
        'role',
        'status',
    ];
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class,'user_id','id');
    }
    public function otp(): HasMany
    {
        return $this->hasMany(Otp::class);
    }
    public function roleAccount(): BelongsTo
    {
        return $this->belongsTo(RoleAccount::class);
    }
    public function userToken(): HasOne
    {
        return $this->hasOne(UserToken::class);
    }
     public function userCommunity(): HasMany
    {
        return $this->hasMany(UserCommunity::class,'user_id','inviter_id','id');
    }
    public function eventComment(): HasMany{
        return $this->hasMany(EventComment::class,'user_id','id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin_transaction',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
