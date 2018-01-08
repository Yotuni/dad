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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('games', 'GameController');

Route::post('/block/{user}', 'UserController@blockUser')->name('blockUser');

Route::post('/hidden/{image}', 'ImageController@activeHiddenFace')->name('activeHiddenFace');

Route::post('/shown/{image}', 'ImageController@activeShownFace')->name('activeShownFace');

Route::get('/games/show/{id}', 'GameController@show')->name('show');

Route::get('/hiddenFace', 'ImageController@hiddenFace')->name('hiddenFace');

Route::get('/shownFace', 'ImageController@shownFace')->name('shownFace');

Route::get('/lobby','MemoryGameController@index');
