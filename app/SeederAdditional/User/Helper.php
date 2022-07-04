<?php
namespace App\SeederAdditional\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Helper{
    public static function phoneGenerator(){
        $len = 7;
        $x = '';

        for ($i = 0 ; $i < $len ; $i ++){
            $x .= intval(rand(0,9));
        }

        return '+380'.Arr::random(config('constants.phoneOperators')).$x;
    }

    public static function emailGenerator($randNameStr){
        return Str::lower($randNameStr.Str::random(2)).'@'.Arr::random(config('constants.hosts'));
    }
}