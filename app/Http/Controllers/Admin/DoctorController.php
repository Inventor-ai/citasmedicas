<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Specialty;

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
      $specialties = Specialty::all();
      return view('doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request->all());
      // dd($request);
      $rules = [
        'name'          => 'required|min:3',
        'email'         => 'required|email',
        'identity_card' => 'nullable|digits:8',
        'address'       => 'nullable|min:5',
        'phone'         => 'nullable|min:10'  // Video: min:6
      ];
      $this->validate($request, $rules);
      $user = User::create(
                 $request->only('name', 'email', 'identity_card', 'address', 'phone')
                 + [ 
                     'role' => 'doctor',
                     'password' => bcrypt( $request->input('password') )
                  ]
      );
      $user->specialties()->attach($request->input('specialties'));
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
      $specialties = Specialty::all();
      $specialties_ids = $doctor->specialties()->pluck('specialties.id');
      return view('doctors.edit', compact('doctor', 'specialties', 'specialties_ids'));
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
            'phone'         => 'nullable|min:10'  // min:6  - Video
        ];
        $this->validate($request, $rules);
          
        $doctor   = User::doctors()->findOrFail($id);
        $data     = $request->only('name', 'email', 'identity_card', 'address', 'phone');
        $password = $request->input('password');
        if ($password)
            $data['password'] = bcrypt( $password );
        $doctor->fill( $data );
        $doctor->save();
        $doctor->specialties()->sync($request->input('specialties'));

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
