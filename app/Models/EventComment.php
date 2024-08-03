<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user_id',
        'comments',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
