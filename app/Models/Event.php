<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable =[
        'community_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'rsvp',
        'status',
    ];
}
