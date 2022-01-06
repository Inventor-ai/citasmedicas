<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class DoctoresController extends Controller
{
  private $mainItem  = 'médico';
  private $mainRoute = 'doctores';

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
    $doctors = User::doctors()->paginate(5);            // Paginación
    return view("$this->mainRoute.index", compact('doctors') );
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
    $this->verificar($request);  // Replaces upper validation call
    // Mass Assignment
    User::create(
      $request->only('name', 'email', 'identity_card', 'address', 'phone') +
         [
            'role'     => 'doctor',
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
  public function edit(User $doctore)
  {
    return view("$this->mainRoute.edit", compact('doctore'));
  }
  public function edit_own($id)
  {
    $doctor = User::doctors()->findOrFail($id);
    return view("$this->mainRoute.edit", compact('doctor'));
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
    $this->verificar($request);  // Replaces upper validation call
    $doctor   = User::doctors()->findOrFail($id);
    $data     = $request->only('name', 'email', 'identity_card', 'address', 'phone');
    $password = $request->input('password');
    if ($password)
        $data['password'] = bcrypt( $password );          // video
        // $data+= [ 'password' => bcrypt( $password ) ]; // Own Ok
    $doctor->fill( $data );
    $doctor->save();
    $notification = "¡La información del $this->mainItem: ".$doctor->name.' se actualizó correctamente!';
    return redirect("/$this->mainRoute")->with(compact('notification'));    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
    // Es igual que en DoctorController.php y PatientController.php pero no funciona. 
    // ¡¡¡No borra el registro!!!
    // Porque no se conecta a la DB y por ende no encuentra tabla/registro
  public function destroy(User $doctore)
  {
    $name = $doctore->name;
    $doctore->delete();
    $notification = "¡Los datos del $this->mainItem: $name se han eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }
  public function destroy_ok($id)
  {
    $doctor = User::doctors()->findOrFail($id);
    $name   = $doctor->name;
    $doctor->delete();
    // $notification = "¡Los datos del $this->mainItem: $name se han eliminado con éxito!";
    $notification = "¡La información del $this->mainItem: $name se ha eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }
}
