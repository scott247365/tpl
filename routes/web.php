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

//sbw, call a view directly
//Route::get('/', function () { return view('welcome'); });

Auth::routes();

Route::get('/', 'EntryController@index')->middleware('auth');

// Route::get('/entry','EntryController@add')->middleware('auth');
// Route::post('/entry','EntryController@create')->middleware('auth');

// Route::get('/entry/{entry}','EntryController@edit')->middleware('auth');
// Route::post('/entry/{entry}','EntryController@update')->middleware('auth');

Route::group(['prefix' => 'entries'], function () {
	
	Route::get('/view/{entry}','EntryController@view')->middleware('auth');
	
	Route::get('/add','EntryController@add')->middleware('auth');
	Route::post('/create','EntryController@create')->middleware('auth');

	Route::get('/edit/{entry}','EntryController@edit')->middleware('auth');
	Route::post('/update/{entry}','EntryController@update')->middleware('auth');
	
	Route::post('/delete/{entry}','EntryController@delete')->middleware('auth');
});

