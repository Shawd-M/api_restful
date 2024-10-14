<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/auth', 'App\Http\Controllers\AuthController@login');
Route::post('/user', 'App\Http\Controllers\AuthController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user-detail', 'Api\AuthController@userDetail');
});

Route::post('user', [UserController::class, 'createUser']);
Route::delete('user/{id}', [UserController::class, 'deleteUser']);
Route::put('user/{id}', [UserController::class, 'updateUser']);