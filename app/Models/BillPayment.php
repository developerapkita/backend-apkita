<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    use HasFactory;
    protected $fillable =[
        'community_id',
        'invoice_number',
        'amount',
        'midtrans_token',
        'midtrans_redirect_url',
        'status'
    ];
}
