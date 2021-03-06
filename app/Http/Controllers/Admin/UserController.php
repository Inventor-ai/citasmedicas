<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
  private $mainItem  = 'usuario';
  private $mainRoute = 'users';

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    // $mainData = User::paginate(5);
    $mainData = User::users()->paginate(5);
    return view("$this->mainRoute.index")->with( compact('mainData') );
  }

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

  public function store(Request $request)
  {
    $this->verificar($request);
    User::create(
      $request->only('name', 'email', 'identity_card', 'phone', 'address') +
         [
            'role'     => 'admin',
            'password' => bcrypt( $request->input('password') )
         ]
    );
    $notification = "¡Datos del $this->mainItem: ".$request->input('password')." guardados exitosamente!";
    return redirect ("/$this->mainRoute")->with( compact('notification') );
  }

  public function edit(User $user)
  {
    // dd($user);
    // return view("$this->mainRoute.edit", compact('user'));  // Works Ok
    $mainData = $user;                                         // Renaming variable
    return view("$this->mainRoute.edit", compact('mainData'));
  }

  public function update(Request $request, $id)
  {
    $this->verificar($request);
    $user     = User::users()->findOrFail($id);
    $data     = $request->only('name', 'email', 'identity_card', 'address', 'phone');
    $password = $request->input('password');
    if ($password) 
        $data+= [ 'password' => bcrypt( $password ) ]; // Own Ok
    //  $data['password'] = bcrypt( $password );       // video Ok
    $user->fill( $data );
    $user->save();
    $notification = "Datos del $this->mainItem ".$request->input('name').' registrados correctamente';
    // $notification = "Datos del $this->mainItem ".$user->name.' registrados correctamente';
    // $notification = '¡La información del paciente: '.$user->name.' se actualizó correctamente!';
    return redirect("/$this->mainRoute")->with( compact('notification') );
  }

  public function destroy(User $user)
  {
    // dd($user);
    $name = $user->name;
    $user->delete();
    $notification = "¡La información del $this->mainItem: $name se ha eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }
  public function destroy_ok($id)    // Own Ok
  {
    $user = User::users()->findOrFail($id);
    $name = $user->name;
    $user->delete();
    $notification = "¡La información del $this->mainItem: $name se ha eliminado con éxito!";
    return redirect("/$this->mainRoute")->with(compact('notification'));
  }

}
