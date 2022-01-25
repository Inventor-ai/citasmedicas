<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ScheduleServiceInterface;
use App\Specialty;
use App\Appointment;
use App\AppointmentCancellation;
use Carbon\Carbon;
use Validator;

class AppointmentController extends Controller
{
  
  public function index()
  {
    // dd( auth()->user() );
    $role = auth()->user()->role;
    // $appointments = Appointment::all();
    $recsPerPage = 5;
    if ($role == 'admin') {
      $appointmentsPending   = Appointment::where('status', 'Reservada' )
                                          // ->where("doctor_id", auth()->id())
                                          ->paginate($recsPerPage);
      $appointmentsConfirmed = Appointment::where('status', 'Confirmada')
                                          // ->where("doctor_id", auth()->id())
                                          ->paginate($recsPerPage);
      $appointmentsLog       = Appointment::whereIn('status', ['Atendida',
                                                                'Cancelada'])
                                          // ->where("doctor_id", auth()->id())
                                          ->paginate($recsPerPage);
    } elseif ($role == 'doctor') {
      $appointmentsPending   = Appointment::where('status', 'Reservada' )
                                          ->where("doctor_id", auth()->id())
                                          ->paginate($recsPerPage);
      $appointmentsConfirmed = Appointment::where('status', 'Confirmada')
                                          ->where("doctor_id", auth()->id())
                                          ->paginate($recsPerPage);
      $appointmentsLog       = Appointment::whereIn('status', ['Atendida',
                                                                'Cancelada'])
                                          ->where("doctor_id", auth()->id())
                                          ->paginate($recsPerPage);
    } elseif ($role == 'patient') {
      $appointmentsPending   = Appointment::where('status', 'Reservada' )
                                          ->where('patient_id', auth()->id())
                                          ->paginate($recsPerPage);
      $appointmentsConfirmed = Appointment::where('status', 'Confirmada')
                                          ->where('patient_id', auth()->id())
                                          ->paginate($recsPerPage);
      $appointmentsLog       = Appointment::whereIn('status', ['Atendida',
                                                               'Cancelada'])
                                          ->where('patient_id', auth()->id())
                                          ->paginate($recsPerPage);
    }
    return view('appointments.index', compact('appointmentsPending',
                'appointmentsConfirmed', 'appointmentsLog', 'role')
    );
  }

  public function show(Appointment $appointment)
  {
    $role = auth()->user()->role;
    return view('appointments.show', compact('appointment', 'role'));
  }

  public function create(ScheduleServiceInterface $scheduleService)
  {
    $endDate = 21;  // To Do: Get this value from Config Service
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

    return view('appointments.create', compact('specialties', 'doctors', 'intervals', 'endDate'));
  }

  public function store(Request $request, ScheduleServiceInterface $scheduleService)
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
    // $this->validate($request, $rules, $mesages);  // Old validations
    $validator = Validator::make($request->all(), $rules, $mesages);
    $validator->after(function ($validator) use ($request, $scheduleService) {
      $doctorId      = $request->input('doctor_id');
      $date          = $request->input('schedule_date');
      $schedule_time = $request->input('schedule_time');
      if ( $doctorId && $date && $schedule_time ) {
           $time = new Carbon ($schedule_time);
      } else {
          return ;
      }
      if (!$scheduleService->isAvailableInterval($doctorId, $date, $time) ) {
           $validator->errors()->add(
              'time_unavailable', 'La hora seleccionada ya se encuentra reservada por otro paciente.'
           );
      }
    });

    if ($validator->fails()) {
        return back ()
             ->withErrors($validator)
             ->withInput();
    }

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
    // dd($data);
    Appointment::create($data);
    $notification = 'La cita se ha registrado correctamente';
    return back()->with(compact('notification'));
    return redirect('/appointments')->with(compact('notification'));
    // return redirect('/appointments', compact('notification'));
    // return redirect('/appointments');
  }

  public function cancelExecute(Appointment $appointment, Request $request)
  {
    if ($request->has('justification') ) {
        $cancellation = new AppointmentCancellation();
        $cancellation->justification = $request->input('justification');
        $cancellation->canceled_by   = auth()->id();
        // $cancellation->appointment_id = $appointment->id;
        // $cancellation->save();
        $appointment->cancellation()->save($cancellation);
    }
    $appointment->status = 'Cancelada';
    $appointment->save();  // update
    // $notification = '¡La cita se ha cancelado correctamente!';
    $notification = '¡La cita de '. $appointment->patient->name . 
                    ' para el '. $appointment->schedule_date .
                    ' a las '  . (new Carbon($appointment->schedule_time))->format('g:i A').
                    ' se ha cancelado correctamente!';
    return redirect('/appointments')->with(compact('notification'));
  }

  public function cancelFormShow(Appointment $appointment)
  {
    if ($appointment->status == 'Confirmada' || $appointment->status == 'Reservada') {
        $role = auth()->user()->role;
        return view('appointments.cancel', compact('appointment', 'role'));
    }
    return redirect('/appointments');
  }

  public function confirm(Appointment $appointment)
  {
    $appointment->status = "Confirmada";
    $appointment->save();
    $notification = '¡La cita de '. $appointment->patient->name . 
                    ' para el '. $appointment->schedule_date .
                    ' a las '  . (new Carbon($appointment->schedule_time))->format('g:i A').
                    ' se ha confirmado correctamente!';
    return redirect('/appointments')->with(compact('notification'));
  }
  
}
