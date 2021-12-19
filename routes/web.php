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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Speciality
// return views
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/create', 'SpecialtyController@create');          // Register form
Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');  // Edit form filled with data
// Manage records
Route::post('/specialties', 'SpecialtyController@store');                 // submit form
Route::put('/specialties/{specialty}', 'SpecialtyController@update');     // Updates record with form data
Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');     // Updates record with form data

// Doctor
Route::resource('doctors', 'DoctorController');
