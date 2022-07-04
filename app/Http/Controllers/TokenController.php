<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function token(Request $request){
        session(['token' => Str::random(275)]);

    	return response()->json(['success' => true, 'token' => session('token')]);
    }
}
