<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WorkDay;
use Carbon\Carbon;
use App\Libs\Items4Select;

class ScheduleController extends Controller
{
  private $days = [
             'Lunes',  'Martes', 'Miércoles',
             'Jueves', 'Viernes','Sábado', 'Domingo'
  ];

  public function edit()
  {
    $workDays = WorkDay::where('user_id', auth()->id())->get();

    if ( count ($workDays) > 0) {
         $workDays->map( function ($workDay) {
         $workDay->morning_start   = (new Carbon($workDay->morning_start  ))->format('g:i A');
         $workDay->morning_end     = (new Carbon($workDay->morning_end    ))->format('g:i A');
         $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
         $workDay->afternoon_end   = (new Carbon($workDay->afternoon_end  ))->format('g:i A');
         return $workDay;
      });
    } else {
      $workDays = collect();
      for ($i=0; $i < 7; $i++)
        $workDays->push(new WorkDay());
    }
    
    $turn1st = Items4Select::getHoursList(1, 11, true);
    $turn2nd = Items4Select::getHoursList(1, 11, false);
    $days    = $this->days;
    return view('schedule', compact('workDays', 'days', 'turn1st', 'turn2nd'));
  }

  public function store(Request $request)
  {
    $active          = $request->input('active') ? : [];
    $morning_start   = $request->input('morning_start');
    $morning_end     = $request->input('morning_end');
    $afternoon_start = $request->input('afternoon_start');
    $afternoon_end   = $request->input('afternoon_end');

    $errors = [];
    for ($i=0; $i < 7; $i++) {
         $errBeg = "Las horas del turno";
         $errEnd = "son inconsistentes para el día";
      if ($morning_start[$i] > $morning_end[$i]) {
          $errors[] = "$morning_start[$i] a $morning_end[$i] ".$this->days[$i]. " turno matutino";
      }
      if ($afternoon_start[$i] > $afternoon_end[$i]) {
          $errors[] = "$afternoon_start[$i] a $afternoon_end[$i] ".$this->days[$i]. " turno vespertino";
      }
      WorkDay::updateOrCreate(
        [ // Key to locate record
          'day'             => $i,
          'user_id'         => auth()->id()
        ],
        [ // Create / Update fields
          'active'          => in_array($i, $active),
          'morning_start'   => $morning_start[$i] ,
          'morning_end'     => $morning_end[$i] ,
          'afternoon_start' => $afternoon_start[$i] ,
          'afternoon_end'   => $afternoon_end[$i]
        ]
      );
    }
    if ( count($errors) > 0 )
         return back()->with(compact('errors'));
    $notification = 'Los cambios se han guardado correctamente';
    return back()->with(compact('notification'));
  }
}
