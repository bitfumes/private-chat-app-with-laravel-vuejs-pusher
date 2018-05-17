<?php


Route::get('/', function () {
    return view('welcome');
});

Route::post('getFriends', 'HomeController@getFriends');
Route::post('/session/create', 'SessionController@create');
Route::post('/send/{session}', 'ChatController@send');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
