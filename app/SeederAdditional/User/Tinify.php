<?php
namespace App\SeederAdditional\User;

class Tinify{
    public static function getCropedCover(){
        \Tinify\setKey(config('tinify.apiKey'));

        $source = \Tinify\fromFile(config('tinify.firstlyIcon'));

        return $source->resize(array(
            "method" => "cover",
            "width" => 70,
            "height" => 70
        ));
    }

    public static function storeCropedCover($resized, $name){
       $resized->toFile(config('filesystems.disks.photos.root')."/{$name}");
    }
}