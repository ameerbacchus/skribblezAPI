<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Root
Route::get('/', 'WelcomeController@index');

// Chapters
Route::get('/chapter', 'ChapterController@getChapter');
// Route::get('/chapters', 'ChapterController@getChapters');

// Route::post('/chapter', 'ChapterController@createChapter');

// Route::put('', '');
// Route::patch('', '');
// Route::delete('', '');