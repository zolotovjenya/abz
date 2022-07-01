<?php
namespace App\SeederAdditional\User;

class Helper{
    public static function phoneGenerator(){
        $len = 9;
        $x = '';

        for ($i = 0 ; $i < $len ; $i ++){
            $x .= intval(rand(0,9));
        }

        return $x;
    }
}