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
  return redirect('/login');  //  return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    // Speciality - return views
    Route::get('/specialties', 'SpecialtyController@index');
    Route::get('/specialties/create', 'SpecialtyController@create');          // Register form
    Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');  // Edit form filled with data
    // Manage records
    Route::post('/specialties', 'SpecialtyController@store');                 // submit form
    Route::put('/specialties/{specialty}', 'SpecialtyController@update');     // Updates record with form data
    Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');     // Updates record with form data

    // Doctor
    Route::resource('doctors', 'DoctorController');

    // Doctor Plus
    Route::resource('doctores', 'DoctoresController');

    // Patient
    Route::resource('patients', 'PatientController');

    // Users
    Route::resource('users', 'UserController');
});

Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function ()
{
  Route::get('/schedule', 'ScheduleController@edit');
  Route::post('/schedule', 'ScheduleController@store');
});

Route::middleware('auth')->group(function ()
{
  Route::get('/appointments/create', 'AppointmentController@create');
  Route::post('/appointments', 'AppointmentController@store');
    /*
       appointments -> Verificar
       -> qué variable pasar a la vista
       -> 1 único blade (condiciones)
    */
  Route::get('/appointments', 'AppointmentController@index');
  Route::get('/appointments/{appointment}', 'AppointmentController@show');

  Route::get ('/appointments/{appointment}/cancel', 'AppointmentController@cancelFormShow');
  Route::post('/appointments/{appointment}/cancel', 'AppointmentController@cancelExecute');

  Route::post('/appointments/{appointment}/confirm', 'AppointmentController@confirm');

  // JSON
  Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
  Route::get('/schedule/hours', 'Api\ScheduleController@hours');
});
