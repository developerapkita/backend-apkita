<?php
namespace App\Services;
use App\Models\Profile;
use Carbon\Carbon;

class ReferalService
{
    // public static function generate(){
    //     $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $number = '0123456789';
    //     $now = Carbon::now();
    //     $date = $now->format('d');  // Mendapatkan bulan dalam bentuk angka (1-12)
        
    //     $stringRandom='';
    //     for($i = 0; $i < 3; $i++){
    //         $stringRandom .= $alphabet[rand(0, strlen($alphabet)-1)];
    //     }
    //     $stringNumber = $number[rand(0, strlen($number)-1)];

    //     $joinString = $stringRandom.$stringNumber.$date;
    //     return str_shuffle($joinString);
    // }
    public static function generate($n,$i){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $charactersLength = strlen($characters);
        $numbersLength = strlen($numbers);
        $codeLength = $n;
        $numberLength = $i;

        $code = '';
        $num = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersLength - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }
        while (strlen($num) < $numberLength) {
            $position = rand(0, $numbersLength - 1);
            $number = $numbers[$position];
            $num = $num.$number;
        }
        $codes = $code.$num;

        if (Profile::where('referal_code', $codes)->exists()) {
            return $this->generate();
        }

        return $codes;
    }
}