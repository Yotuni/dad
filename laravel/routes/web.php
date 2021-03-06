<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/authenticate', 'Auth\LoginController@authenticate')->name('authenticate');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('games', 'GameController');

Route::post('/image/create', 'ImageController@create')->name('createImage');

Route::delete('/image/delete/{id}', 'ImageController@destroy')->name('deleteImage');

Route::post('/block/{user}', 'UserController@blockUser')->name('blockUser');
Route::post('/blockUser/{user}', 'UserController@block')->name('block');

Route::get('/blockUser/{user}', 'UserController@blockUser')->name('blockUser');

Route::post('/recover/{id}', 'UserController@recoverUser')->name('recoverUser');

Route::post('/hidden/{image}', 'ImageController@activeHiddenFace')->name('activeHiddenFace');

Route::post('/shown/{image}', 'ImageController@activeShownFace')->name('activeShownFace');

Route::get('/games/show/{id}', 'GameController@show')->name('show');

Route::get('/hiddenFace', 'ImageController@hiddenFace')->name('hiddenFace');

Route::get('/shownFace', 'ImageController@shownFace')->name('shownFace');



Route::get('/lobby','MemoryGameController@index');

Route::get('/listRemovedUsers','UserController@listRemovedUsers')->name('listRemovedUsers');

