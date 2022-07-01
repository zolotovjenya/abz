<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $req){
        $total = 6;
        
        if($req->has('count')){
            $total = $req->count;    
        }

        $user = new User();
        $users = $user->with('position')->paginate($total);

    	return response()->json($users);
    }
}
