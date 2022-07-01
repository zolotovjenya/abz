<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Positions;
use App\Models\Photos;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            if(Positions::select('id')->count() > 0){
                $positions = [];
                $data = [];
                $photos = [];
    
                foreach(Positions::select('id')->get() as $p){
                    $positions[] = $p->id;
                }

                \Tinify\setKey("TVQ4NgYfs86FJFRVxLZslbwjP6zFhtt6");
                $source = \Tinify\fromFile("https://i.pinimg.com/474x/76/4d/59/764d59d32f61f0f91dec8c442ab052c5.jpg");                
                $resized = $source->resize(array(
                    "method" => "cover",
                    "width" => 70,
                    "height" => 70
                ));    

                for($i=0;$i<5;$i++){
                    $id = $i+1;
                    $name = "{$id}.jpg";
                    $resized->toFile(config('filesystems.disks.photos.root')."/{$name}");

                    $photos[$i] = array(
                        'id' => $id,
                        'name' => $name
                    );

                    $data[$i] = array(
                        'id' => $id,
                        'name' => Str::ucfirst(Str::lower(Str::random(10))),
                        'email' => Str::lower(Str::random(10).'@gmail.com'),
                        'phone' => '+380'.$this->phoneGenerator(),
                        'photo_id' => $id,
                        'position_id' => Arr::random($positions),
                        'registration_timestamp' => Carbon::now()->timestamp
                    );
                }

                Photos::insert($photos);

                User::insert($data);
            }   
        } catch (\Throwable $th) {
            throw $th;
        }     
    }

    public function phoneGenerator(){
        $len = 9;
        $x = '';

        for ($i = 0 ; $i < $len ; $i ++){
            $x .= intval(rand(0,9));
        }

        return $x;
    }
}
