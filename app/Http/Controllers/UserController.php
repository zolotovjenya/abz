<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photos;
use App\SeederAdditional\User\Tinify;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function users(Request $request){
        $validator = Validator::make($request->all(), [
            'page' => 'required|gt:0',
            'count' => 'numeric'
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => [
                    'count' => 'The count must be an integer.',
                    'page' => 'The page must be at least 1.'
                ]
            ], 422);
        }

        $user = new User();

        $users = $user->with('position')->paginate($request->count);

    	return response()->json(['success' => true, 'users' => $users]);
    }

    public function user(Request $request){
        $validator = Validator::make($request->route()->parameters(), [
            'id' => 'required|numeric'
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => [
                    'user_id' => 'The user_id must be an integer.'
                ]
            ], 400);
        }

        $user = new User();
        $data = $user->where('id', $request->route('id'))->first();
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'The user with the requested identifier does not exist',
                'fails' => [
                    'user_id' => 'User not found.'
                ]
            ], 404);
        }

    	return response()->json(['success' => true, 'user' => $data]);
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:60',
            'phone' => "required|regex: /^[\+]{0,1}380([0-9]{9})$/",
            'email' => [
                'required', 
                'email',
                'max:100'
            ],
            'position_id' => 'required|numeric|min:1',
            'photo' => 'image|dimensions:min_width=70,min_height=70'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
            ], 422);
        } elseif(session('token') != $request->header('Token')){           
            return response()->json([
                'success' => false,
                'message' => 'The token expired.'
            ], 401);
        } elseif(User::where('email', $request->email)->count() > 0 || User::where('phone', $request->phone)->count() > 0){
            return response()->json([
                'success' => false,
                'message' => 'User with this phone or email already exist'
            ], 401);
        }

        $lastUser = User::orderBy('id', 'desc')->first();
        $nextUserId = $lastUser->id + 1;
        
        $photo = $request->file('photo');

        if($photo){
            $resized = Tinify::getCropedCover($photo);

            $name = "{$nextUserId}.jpg";
                
            Tinify::storeCropedCover($resized, $name);

            $file = new Photos();

            $file->id = $nextUserId;
            $file->name = $name;
            $file->save();

            $user = new User();

            $user->id = $nextUserId;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->position_id = $request->position_id;
            $user->photo_id = $file->id;
            $user->registration_timestamp = time();

            $user->save();

            return response()->json([
                'success' => true, 
                'user_id' => $user->id, 
                'message' => 'New user successfully registered'
            ]);
        }
        
        
    }
}
