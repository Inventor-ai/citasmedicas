<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DoctorsController extends Controller
{
  private $mainItem  = 'médico';
  private $mainRoute = 'doctorsPlus';

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
    // $doctors = User::all();
    // $doctors = User::where('role', 'doctor')->get(); // Modelo sin scope
    // $doctors = User::Doctors()->get();               // Modelo con Scope. También funciona
    // $doctors = User::doctors()->get();                  // Modelo con Scope (Video)
    $doctors = User::doctors()->paginate(5);                  // Modelo con Scope (Video)
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

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $rules = [
       'name'          => 'required|min:3',
       'email'         => 'required|email',
       'identity_card' => 'nullable|digits:8',
       'address'       => 'nullable|min:5',
       'phone'         => 'nullable|min:10'  // Video: min:6
    ];
    $this->validate($request, $rules);
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
  public function edit($id)
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
    $rules = [
       'name'          => 'required|min:3',
       'email'         => 'required|email',
       'identity_card' => 'nullable|digits:8',
       'address'       => 'nullable|min:5',
       'phone'         => 'nullable|min:10'  // Video: min:6
    ];
    $this->validate($request, $rules);
      
    $doctor   = User::doctors()->findOrFail($id);
    $data     = $request->only('name', 'email', 'identity_card', 'address', 'phone');
    $password = $request->input('password');
    if ($password)
        $data['password'] = bcrypt( $password );          // video
        // $data+= [ 'password' => bcrypt( $password ) ]; // Own Try this one
    $doctor->fill( $data );
    $doctor->save();
    $notification = '¡La información del médico: '.$doctor->name.' se actualizó correctamente!';
    return redirect("/$this->mainRoute")->with(compact('notification'));    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $doctor       = User::doctors()->findOrFail($id);
    // dd($doctor);
    $name         = $doctor->name;
    $doctor->delete();
    // $notification = "¡Los datos del médico: $doctorName se han eliminado con éxito!";
    $notification = "¡La información del $this->mainItem: $name se ha eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }
    // Es igual que en DoctorController.php y PatientController.php pero no funciona. 
    // ¡¡¡No borra el registro!!!
    // Porque no se conecta a la DB y por ende no encuentra tabla/registro
    public function destroy_Fail(User $doctor)
    {
      dd($doctor);
      $doctorName = $doctor->name;
      $doctor->delete();
      $notification = "¡Los datos del médico: $doctorName se han eliminado con éxito!";
      return redirect("/$this->mainRoute")->with(compact('notification'));
    }
}
