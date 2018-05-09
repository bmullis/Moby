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

Route::get('api/users', 'UserController@index');
Route::get('api/users/{user}', 'UserController@show');

Route::get('/api/sightings', 'SightingController@index');
Route::get('/api/sightings/{sighting}', 'SightingController@show');
Route::get('/api/sightingsByUser/{user_id}', 'SightingController@showByUser');
Route::get('/api/sightingsByDate/{date_time}', 'SightingController@showByDate');
