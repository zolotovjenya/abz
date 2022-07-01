<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/**
 * 
 * Get user routes
 */

/* get all users */
Route::get('/users','UserController@index');

/* get user by id */
Route::get('/users/{id}','UserController@user');

/* create new user */
Route::post('/users','UserController@createUser');

/*
get all positions route
*/
Route::get('/positions','PositionController@getAll');

/*
Get token route
*/
Route::get('/token','TokenController@token');