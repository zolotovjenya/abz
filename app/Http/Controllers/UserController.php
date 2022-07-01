<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $req){
        $total = 6;
        
        if($req->has('count')){
            $total = $req->count;    
        }

        $user = new User();
        $users = $user->with('position')->paginate($total);

    	return response()->json(['success' => true, 'users' => $users]);
    }

    public function user(Request $request){
        $validator = Validator::make($request->route()->parameters(), [
            'id' => 'required|numeric'
        ]);
 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = new User();
        $data = $user->where('id', $request->route('id'))->first();
        if(!$data){
            abort(500);
        }

    	return response()->json(['success' => true, 'user' => $data]);
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:60',
            'phone' => "required|regex: /^[\+]{0,1}380([0-9]{9})$/",
            'email' => [
                'required',
                "email"
            ],
            'position_id' => 'required|numeric|min:1',
            'photo' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    }
}
