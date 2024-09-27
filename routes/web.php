<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'PantauController@index')->name('pantau');
Route::get('/pantau', 'PantauController@index')->name('pantau');
Route::get('/hasil', 'PantauController@hasil')->name('hasil');
Route::get('/export/{id}', 'PantauController@export')->name('export');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
