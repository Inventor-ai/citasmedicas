<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class PatientController extends Controller
{
  private $mainItem  = 'paciente';
  private $mainRoute = 'patients';

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
    $patients = User::patients()->paginate(5);
    return view("$this->mainRoute.index", compact('patients') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("$this->mainRoute.create");
  }

  private function verificar($request)
  {
    $rules = [
       'name'          => 'required|min:3',
       'email'         => 'required|email',
       'identity_card' => 'nullable|digits:8',
       'address'       => 'nullable|min:5',
       'phone'         => 'nullable|min:10'  // Video: min:6
    ];
    $this->validate($request, $rules);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->verificar($request);  // Exceute Laravel validation call
    // Mass Assignment
    User::create(
      $request->only('name', 'email', 'identity_card', 'address', 'phone') +
         [
            'role'     => 'patient',
            'password' => bcrypt( $request->input('password') )
         ]
    );
    $notification = "Datos del $this->mainItem: ".$request->input('name').' registrados correctamente';
    return redirect("/$this->mainRoute")->with( compact('notification') );
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
  public function edit(User $patient)  // Video - Ok
  {
    return view("$this->mainRoute.edit", compact('patient'));
  }
  public function edit_Ok($id)         // Ok - Own
  {
    $patient = User::patients()->findOrFail($id);
    return view("$this->mainRoute.edit", compact('patient'));
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
    $this->verificar($request);  // Exceute Laravel validation call
    $patient  = User::patients()->findOrFail($id);
    $data     = $request->only('name', 'email', 'identity_card', 'address', 'phone');
    $password = $request->input('password');
    if ($password) 
        $data+= [ 'password' => bcrypt( $password ) ]; // Own Ok
    //  $data['password'] = bcrypt( $password );       // video Ok
    $patient->fill( $data );
    $patient->save();
    $notification = "Datos del $this->mainItem ".$request->input('name').' registrados correctamente';
    // $notification = "Datos del $this->mainItem ".$patient->name.' registrados correctamente';
    // $notification = '¡La información del paciente: '.$patient->name.' se actualizó correctamente!';
    return redirect("/$this->mainRoute")->with( compact('notification') );
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $patient)
  {
    // dd($patient);
    $name         = $patient->name;
    $patient->delete();
    $notification = "¡La información del $this->mainItem: $name se ha eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }
  public function destroy_ok($id)    // Own Ok
  {
    $patient      = User::patients()->findOrFail($id);
    $name         = $patient->name;
    $patient->delete();
    $notification = "¡La información del $this->mainItem: $name se ha eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }
}
