<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_code',
        'name_community',
        'description',
        'address',
        'balance',
    ];
    public function userCommunity(): HasMany
    {
        return $this->hasMany(userCommunity::class);
    }
    public function balanceCommunity(): HasOne
    {
        return $this->hasOne(BalanceCommunity::class);
    }
    public function contribution(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }
    public function billPayment(): HasMany
    {
        return $this->hasMany(BillPayment::class);
    }
    public function event(): HasMany
    {
        return $this->hasMany(Event::class);
    }
    public function poll(): HasMany
    {
        return $this->hasMany(Poll::class);
    }
    public function complain(): HasMany
    {
        return $this->hasMany(Complain::class);
    }
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

}
