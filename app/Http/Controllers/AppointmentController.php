<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialty;
use App\Appointment;

class AppointmentController extends Controller
{
  public function create()
  {
    $specialties = Specialty::all();
    // dd($specialties);
    // dd($specialties)->toArray();
    $specialtyId = old('specialty_id');
    if ( $specialtyId ) {
         $specialty = Specialty::find( $specialtyId );
         $doctors = $specialty->users;
    } else {
         $doctors = collect();
    }   
    return view('appointments.create', compact('specialties', 'doctors'));
  }

  public function store(Request $request)
  {
    // dd($request);
    $rules = [
      'description' => 'required',
       'specialty_id' => 'required|exists:specialties,id',
       'doctor_id' => 'required|exists:users,id',
      //  'schedule_date' => 'required',
       'schedule_time' => 'required',
      //  'type' => 'required|'
    ];

    $mesages = [
      'schedule_time.required' => 'Por favor seleccione una hora válida para su cita.',
    ];

    $this->validate($request, $rules, $mesages);
    $data = $request->only(
       'description',
       'specialty_id',
       'doctor_id',
       
       'schedule_date',
       'schedule_time',
       'type'
    );
    $data['patient_id'] = auth()->id();
    Appointment::create($date);
    $notification = 'La cita se ha registrado correctamente';
    return back()->with(compact('notification'));
    // return redirect('/appointments')
  }
}
