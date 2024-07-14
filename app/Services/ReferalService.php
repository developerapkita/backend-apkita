<?php
namespace App\Services;
class ReferalService
{
    public static function generate(){
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $number = '0123456789';
        $stringRandom='';
        for($i = 0; $i < 3; $i++){
            $stringRandom .= $alphabet[rand(0, strlen($alphabet)-1)];
        }
        $stringNumber='';
        for($i = 0; $i < 3; $i++){
            $stringNumber .= $number[rand(0, strlen($number)-1)];
        }
        $joinString = $stringRandom.$stringNumber;
        return $joinString;
    }
}