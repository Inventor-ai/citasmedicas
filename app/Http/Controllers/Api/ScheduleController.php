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

    // dd($request->all());
    // dd($day);

    $doctorid = $request->input('doctor_id');

    $workDays = WorkDay::where('active', true)
                        ->where('day', $day)
                        ->where('user_id', $doctorid)
                        ->first([
                            'morning_start',   'morning_end',
                            'afternoon_start', 'afternoon_end'
                        ]);

    $morningIntervals = $this->getIntervals($workDays->morning_start, 
                                            $workDays->morning_end);

    $afternoonIntervals = $this->getIntervals($workDays->afternoon_start, 
                                              $workDays->afternoon_end);
    $data = [];
    $data['morning']   = $morningIntervals;
    $data['afternoon'] = $afternoonIntervals;
    return $data;
    dd($data);

    $afternoonStart = new Carbon($workDays->afternoon_start);
    $afternoonEnd = new Carbon($workDays->afternoon_end);    
    dd($workDays->toArray());
    // $table->increments('id');

    // $table->unsignedSmallInteger('day');
    // $table->boolean('active');

    // $table->time('morning_start');
    // $table->time('morning_end');

    // $table->time('afternoon_start');
    // $table->time('afternoon_end');

    // $table->unsignedBigInteger('user_id');
    // $table->foreign('user_id')->references('id')->on('users');

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
