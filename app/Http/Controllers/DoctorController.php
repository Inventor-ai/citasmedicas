<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DoctorController extends Controller
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
    //   $doctors = User::all();
    //   $doctors = User::where('role', 'doctor')->get(); // Modelo sin scope
    //   $doctors = User::Doctors()->get();               // Modelo con Scope. También funciona
      $doctors = User::doctors()->get();                  // Modelo con Scope (Video)
      return view('doctors.index', compact('doctors') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('doctors.create');
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

      // Array asociativo creado manualmente
      //   User::create(
      //     [
      //       'name'           => $request->input('name') ,
      //       'email'          => 'required|email',
      //       'indentity_card' => 'digits:8',
      //       'address'        => 'min:5',
      //       'phone'          => 'min:10'  // Video: min:6
      //     ]
      //   );

      // Mass Assignment
      User::create(
        $request->only('name', 'email', 'identity_card', 'address', 'phone')
                 + [ 
                     'role' => 'doctor',
                     'password' => bcrypt( $request->input('password') )
                  ]
      );
      $notification = 'El médico se ha registrado correctamente';
      return redirect('/doctors')->with(compact('notification'));
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
      return view('doctors.edit', compact('doctor'));
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
        return redirect('/doctors')->with(compact('notification'));    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $doctor)
    {
      $doctorName = $doctor->name;
      $doctor->delete();
      $notification = "¡Los datos del médico: $doctorName se han eliminado con éxito!";
      return redirect('/doctors')->with(compact('notification'));
    }
/*
    // Otra manera de borrar físicamente el registro
    public function destroy($id)
    { // Usando findOrFail
      $doctor = User::doctors()->findOrFail($id);
    //   dd($doctor);
      $doctorName = $doctor->name;
      $doctor->delete();
      $notification = "¡Los datos del médico: $doctorName se han eliminado con éxito!";
      return redirect('/doctors')->with(compact('notification'));
    }
*/
}
