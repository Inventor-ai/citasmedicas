<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WorkDay;
use Carbon\Carbon;

class ScheduleController extends Controller
{
  public function hours(Request $request)
  {
    $rules = [
      'date'      => 'required|date_format:"Y-m-d"',
      'doctor_id' => 'required|exists:users,id'
    ];
    $this->validate($request, $rules);

    $date = $request->input('date');
    $dateCarbon = new Carbon($date);
    $day = $dateCarbon->dayOfWeek;
    // dayOfWeek
    // Carbon : 0 = sunday - 6 = saturday
    // WorkDay: 0 = monday - 6 = sunday
    $day = ( $day == 0 ? 6 : $day - 1);
    $doctorid = $request->input('doctor_id');
    $workDays = WorkDay::where('active', true)
                        ->where('day', $day)
                        ->where('user_id', $doctorid)
                        ->first([
                            'morning_start',   'morning_end',
                            'afternoon_start', 'afternoon_end'
                        ]
    );
    
    if (!$workDays) return [];

    $morningIntervals = $this->getIntervals($workDays->morning_start, 
                                            $workDays->morning_end);

    $afternoonIntervals = $this->getIntervals($workDays->afternoon_start, 
                                              $workDays->afternoon_end);
    $data = [];
    $data['morning']   = $morningIntervals;
    $data['afternoon'] = $afternoonIntervals;
    return $data;
  }

  private function getIntervals($start, $end)
  {
    $start = new Carbon($start);
    $end = new Carbon($end);

    $intervals = [];
    while ($start < $end) {
      $interval = [];
      $interval['start'] = $start->format('g:i:A');
      $start->addMinutes(30);
      $interval['end']   = $start->format('g:i:A');
      $Intervals[] = $interval;
    }
    return $Intervals;
  }
}
