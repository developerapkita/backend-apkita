<?php
namespace App\Services;
use App\Models\Profile;
use Carbon\Carbon;

class ReferalService
{
    public static function generate(){
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $number = '0123456789';
        $now = Carbon::now();
        $date = $now->format('d');  // Mendapatkan bulan dalam bentuk angka (1-12)
        
        $stringRandom='';
        for($i = 0; $i < 3; $i++){
            $stringRandom .= $alphabet[rand(0, strlen($alphabet)-1)];
        }
        $stringNumber = $number[rand(0, strlen($number)-1)];

        $joinString = $stringRandom.$stringNumber.$date;
        return str_shuffle($joinString);
    }
}