<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('games', 'GameControllerAPI@all');
Route::get('images', 'ImageControllerAPI@all');
Route::get('games/show/{id}', 'GameControllerAPI@show')->name('show');
Route::get('games/{id}', 'GameControllerAPI@joinGame')->name('joinGame');
Route::delete('games/{id}', 'GameControllerAPI@delete');