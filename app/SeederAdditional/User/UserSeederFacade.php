<?php
namespace App\SeederAdditional\User;

use App\Models\Positions;
use App\Models\User;
use App\Models\Photos;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\SeederAdditional\User\Tinify;
use App\SeederAdditional\User\Helper;

class UserSeederFacade{
    public function write(){
        if(Positions::select('id')->count() > 0){
            $positions = [];
            $users = [];
            $photos = [];

            foreach(Positions::select('id')->get() as $p){
                $positions[] = $p->id;
            }

            $resized = Tinify::getCropedCover();

            for($i=0;$i<45;$i++){
                $id = $i+1;
                $name = "{$id}.jpg";
                
                Tinify::storeCropedCover($resized, $name);

                $photos[$i] = array(
                    'id' => $id,
                    'name' => $name
                );

                $users[$i] = array(
                    'id' => $id,
                    'name' => Str::ucfirst(Str::lower(Str::random(10))),
                    'email' => Str::lower(Str::random(10).'@gmail.com'),
                    'phone' => '+380'.Helper::phoneGenerator(),
                    'photo_id' => $id,
                    'position_id' => Arr::random($positions),
                    'registration_timestamp' => Carbon::now()->timestamp
                );
            }

            Photos::insert($photos);

            User::insert($users);
        }
    }
}