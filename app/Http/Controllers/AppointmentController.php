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
  private function getPageSize()
  {
    return 5; // Setting from DB
  }

  private function getData($status = 'Confirmada', $view = 'confirmed', $page = null)
  {
    $role = auth()->user()->role;
    $rpwp = $this->getPageSize(); // Records Per Web Page = rpwp
    if ($view == 'log') {
        if ($role == 'admin') {
            $appointments = Appointment::whereIn('status', $status)
                                       ->paginate($rpwp);
        } elseif ($role == 'doctor') {
            $appointments = Appointment::whereIn('status', $status)
                                       ->where("doctor_id", auth()->id())
                                       ->paginate($rpwp);
        } elseif ($role == 'patient') {
            $appointments = Appointment::whereIn('status', $status)
                                       ->where('patient_id', auth()->id())
                                       ->paginate($rpwp);
        }
    } else {
        if ($role == 'admin') {
            $appointments = Appointment::where('status', $status)
                                       ->paginate($rpwp);
        } elseif ($role == 'doctor') {
            $appointments = Appointment::where('status', $status)
                                       ->where("doctor_id", auth()->id())
                                       ->paginate($rpwp);
        } elseif ($role == 'patient') {
            $appointments = Appointment::where('status', $status)
                                       ->where('patient_id', auth()->id())
                                       ->paginate($rpwp);
        }
    }
    $page = $page ? "page=$page" : "";
    return view("appointments.tables.$view", compact('appointments', 'role', 'page'));
  }

  public function index(Request $request)
  {
    $page = $request->input('page');
    return $this->getData('Confirmada', 'confirmed', $page);
  }

  public function indexPending(Request $request)
  {
    $page = $request->input('page');
    return $this->getData('Reservada', 'pending', $page);
  }

  public function indexLog(Request $request)
  {
    $page = $request->input('page');
    return $this->getData(['Atendida', 'Cancelada'], 'log', $page);
  }

  private function setRequest($request)
  {
    $page    = $request->input('page');
    $tabName = $request->input('tabName');
    $tabName = $tabName ? "/$tabName" : "";
    if ($page) $tabName = "$tabName?page=$page";
    return $tabName;
  }

  public function show(Appointment $appointment, Request $request)
  {
    $tabName = $this->setRequest($request);
    $role = auth()->user()->role;
    return view('appointments.show', compact('appointment', 'role', 'tabName'));
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
    Appointment::create($data);
    $notification = 'La cita se ha registrado correctamente';
    // return back()->with(compact('notification'));
    return redirect('/appointments')->with(compact('notification'));
    // return redirect('/appointments', compact('notification'));
    // return redirect('/appointments');
  }

  public function cancelExecute(Appointment $appointment, Request $request)
  {
    if ($request->has('justification') ) {
        $cancellation = new AppointmentCancellation();
        $cancellation->justification  = $request->input('justification');
        // $cancellation->canceled_by   = auth()->id(); // ???
        $cancellation->canceled_by_id = auth()->id();
        // $cancellation->appointment_id = $appointment->id;
        // $cancellation->save();
        $appointment->cancellation()->save($cancellation);
    }
    $appointment->status = 'Cancelada';
    $appointment->save();  // update
    // $notification = '¡La cita se ha cancelado correctamente!';
    // $notification = '¡La cita de '. $appointment->patient->name . 
    //                 ' para el '. $appointment->schedule_date .
    //                 ' a las ' . (new Carbon($appointment->schedule_time))->format('g:i A').
    //                 ' se ha cancelado correctamente!';
    $notification = '¡Cita para el '. $appointment->schedule_date .
                    ' a las ' . $appointment->scheduled_time_12.
                    ' cancelada correctamente!';
    return redirect('/appointments')->with(compact('notification'));
  }

  public function cancelFormShow(Appointment $appointment, Request $request)
  {
    $tabName = $this->setRequest($request);
    if ($appointment->status == 'Confirmada' || $appointment->status == 'Reservada') {
        $role = auth()->user()->role;
        return view('appointments.cancel', compact('appointment', 'role', 'tabName'));
    }
    return redirect("/appointments$tabName");
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
