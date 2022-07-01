<?php

use Illuminate\Database\Seeder;

use App\SeederAdditional\User\UserSeederFacade;

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
            $userSeederFacade = new UserSeederFacade();

            $data = $userSeederFacade->write();
        } catch (\Throwable $th) {
            throw $th;
        }     
    }
}
