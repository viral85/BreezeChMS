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
    return Redirect::to('/dashboard');
});

Route::get('/login', 'Auth\LoginController@index');
Route::post('/logincheck', 'Auth\LoginController@authenticate');
Route::get('/logout', 'DashboardController@getLogout');

Route::get('/dashboard', 'PeopleController@index');
Route::get('/uploadcsv', 'PeopleController@uploadCsv');
Route::post('/savecsv', 'PeopleController@importCsv');
Route::post('/getPeopleData', 'PeopleController@getPeopleData');
