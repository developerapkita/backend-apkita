<?php

namespace App\Helper;

use stdClass;
use App\Models\Community;

class Communities
{
    public static function generateCode($n){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = $n;

        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }

        if (Community::where('invitation_code', $code)->exists()) {
            return $this->generateUniqueCode();
        }

        return $code;
    }
}

