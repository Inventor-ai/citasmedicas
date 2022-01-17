<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;
use App\Specialty;
use App\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
  public function create(ScheduleServiceInterface $scheduleService)
  {
    $specialties = Specialty::all();
    $specialtyId = old('specialty_id');
    if ( $specialtyId ) {
         $specialty = Specialty::find( $specialtyId );
         $doctors = $specialty->users;
    } else {
         $doctors = collect();
    }

    $scheduleDate = old('schedule_date');
    $doctorId = old('doctor_id');

    if ($scheduleDate && $doctorId) {
      $intervals = $scheduleService->getAvailableIntervals($scheduleDate, $doctorId);
    } else {
      $intervals = null;
    }

    return view('appointments.create', compact('specialties', 'doctors', 'intervals'));
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
    // right time format
    $carbonTime = Carbon::createFromFormat('g:i A', $data['schedule_time'] );
    $data['schedule_time'] = $carbonTime->format('H:i:s');
    ;
    // dd($data);
    Appointment::create($data);
    $notification = 'La cita se ha registrado correctamente';
    return back()->with(compact('notification'));
    // return redirect('/appointments')
  }
}
