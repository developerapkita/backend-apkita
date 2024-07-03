<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceUser extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'debit',
        'credit',
        'balance',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
