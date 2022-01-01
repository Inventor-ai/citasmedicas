<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PatientController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $patients = User::all();
    // $patients = User::where('role', 'patient')->get(); // Modelo sin Scope
    // $patients = User::Patients()->get();               // Modelo con Scope. También funciona
    $patients = User::patients()->get();                  // Modelo con Scope (Video)
    return view('patients.index', compact('patients') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('patients.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //dd($request);
    $rules = [
       'name'          => 'required|min:3',
       'email'         => 'required|email',
       'identity_card' => 'nullable|digits:8',
       'address'       => 'nullable|min:5',
       'phone'         => 'nullable|min:10'
    ];
    $this->validate($request, $rules);
    User::create(
      $request->only('name', 'email', 'identity_card', 'address', 'phone') +
         [
            'role'     => 'patient',
            'password' => bcrypt($request->input('password') )
         ]
    );
    $notification = 'Datos del paciente registrados correctamente';
    return redirect('/patients')->with( compact('notification'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $patient = User::patients()->findOrFail($id);
    return view('patients.edit', compact('patient'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //dd($request);
    $rules = [
       'name'          => 'required|min:3',
       'email'         => 'required|email',
       'identity_card' => 'nullable|digits:8',
       'address'       => 'nullable|min:5',
       'phone'         => 'nullable|min:10'
    ];
    $this->validate($request, $rules);

    $patient = User::patients()->findOrFail($id);
    $data = $request->only('name', 'email', 'identity_card', 'address', 'phone');
    $password = $request->input('password');
    if ($password) 
        $data+= [ 'password' => bcrypt( $password ) ]; // Own Try this one
    // $data['password'] = bcrypt( $password ); // video
    $patient->fill( $data );
    $patient->save();
    $notification = '¡La información del paciente: '.$patient->name.' se actualizó correctamente!';
    return redirect ('/patients')->with(compact('notification'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $patient = User::patients()->findOrFail($id);
    $patientName = $patient->name;
    $patient->delete();
    $notification = "¡La información del paciente: $patientName se ha eliminado con éxito!";
    return redirect ('/patients')->with(compact('notification'));
  }
}
