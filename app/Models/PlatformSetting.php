<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    use HasFactory;
    protected $fillable =[
        'version_mobile',
        'version_website',
        'phone',
        'address',
        'data',
        'is_read',
    ];
    
}
