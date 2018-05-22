<?php


Route::get('/', function () {
    return view('welcome');
});

Route::post('getFriends', 'HomeController@getFriends');
Route::post('/session/create', 'SessionController@create');
Route::post('/session/{session}/chats', 'ChatController@chats');
Route::post('/session/{session}/read', 'ChatController@read');
Route::post('/session/{session}/clear', 'ChatController@clear');
Route::post('/send/{session}', 'ChatController@send');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
