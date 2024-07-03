<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

     /**
     * Kita override boot method
     *
     * Mengisi primary key secara otomatis dengan UUID ketika membuat record
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Kita override getIncrementing method
     *
     * Menonaktifkan auto increment
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Kita override getKeyType method
     *
     * Memberi tahu laravel bahwa model ini menggunakan primary key bertipe string
     */
    public function getKeyType()
    {
        return 'string';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'pin_transaction',
        'role_account',
        'status_account',
    ];
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    public function otp(): HasMany
    {
        return $this->hasMany(Otp::class);
    }
    public function roleAccount(): BelongsTo
    {
        return $this->belongsTo(RoleAccount::class);
    }
    public function userCommunity(): HasMany
    {
        return $this->hasMany(UserCommunity::class);
    }
    public function balanceUser(): HasOne
    {
        return $this->hasOne(BalanceUser::class);
    }
    public function bill(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
    public function userPoll(): HasMany
    {
        return $this->hasMany(UserPoll::class);
    }
    public function complain(): HasMany
    {
        return $this->hasMany(Complain::class);
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
