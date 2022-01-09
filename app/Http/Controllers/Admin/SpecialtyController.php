<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Specialty;

class SpecialtyController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index() {
    $specialties = Specialty::all();
    return view('specialties.index', compact('specialties'));
  }

  public function create() 
  {
    return view('specialties.create');
  }

  private function performValidation( $request )
  {
    $rules = [ 'name' => 'required|min:3' ];
    $messges = [
      'name.required' => 'Es necesario ingresar un nombre',
      'name.min'      => 'Como mínimo el nombre debe tener 3 caracteres'
    ];
    $this->validate($request, $rules, $messges);
  }

  public function store(Request $request) 
  {
    // dd($request->all());
    // $rules = [ 'name' => 'required|min:3' ];
    // $messges = [
    //   'name.required' => 'Es necesario ingresar un nombre',
    //   'name.min'      => 'Como mínimo el nombre debe tener 3 caracteres'
    // ];
    // $this->validate($request, $rules, $messges);
    $this->performValidation( $request );
    $specialty = new Specialty();
    $specialty->name        = $request->input('name');
    $specialty->description = $request->input('description');
    $specialty->save();              // Insert DB
    // return back();                // Returns user to last page before insert
    $notification = "¡La especialidad $specialty->name se ha registrado correctamente!";
    return redirect('/specialties')->with( compact('notification') ); // Return to Spacialties list
  }

  public function edit(Specialty $specialty)
  {
    return view('specialties.edit', compact('specialty'));
  }
  
  public function update(Request $request, Specialty $specialty)
  {
    // dd($request->all());
    // $rules = [ 'name' => 'required|min:3' ];
    // $messges = [
    //   'name.required' => 'Es necesario ingresar un nombre',
    //   'name.min'      => 'Como mínimo el nombre debe tener 3 caracteres'
    // ];
    // $this->validate($request, $rules, $messges);
    $this->performValidation( $request );
    $specialty->name        = $request->input('name');
    $specialty->description = $request->input('description');
    $specialty->save();              // UPDATE
    $notification = "¡La especialidad $specialty->name se ha actualizado correctamente!";
    return redirect('/specialties')->with( compact('notification') ); // Return to Spacialties list
  }

  public function destroy(Specialty $specialty)
  {
    // dd($specialty->name);
    $specialty->delete();
    $notification = '¡La especialidad '. $specialty->name .' se ha eliminado correctamente!';
    return redirect('/specialties')->with( compact('notification') ); // Return to Spacialties list
  }

}
/*
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/create', 'SpecialtyController@create');          // Register form
Route::get('/specialties/{Specialty}/edit', 'SpecialtyController@edit'); // Edit form filled with data
Route::post('/specialties', 'SpecialtyController@store');                 // submit form
*/