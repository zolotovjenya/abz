<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function token(){
        session(['token' => Str::random(32)]);

    	return response()->json(['success' => true, 'token' => session('token')]);
    }
}
