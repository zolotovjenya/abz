<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Positions;
use Illuminate\Support\Facades\Validator;


class PositionController extends Controller
{
    public function getAll(){
        $data = Positions::all();

    	return response()->json(['success' => true, 'positions' => $data]);
    }
}
