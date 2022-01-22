<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\ScheduleServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WorkDay;

class ScheduleController extends Controller
{
  public function hours(Request $request, ScheduleServiceInterface $scheduleService)
  {
    $rules = [
      'date'      => 'required|date_format:"Y-m-d"',
      'doctor_id' => 'required|exists:users,id'
    ];
    $this->validate($request, $rules);

    $date = $request->input('date');
    /*
    // dayOfWeek
    // Carbon : 0 = sunday - 6 = saturday
    // WorkDay: 0 = monday - 6 = sunday
    $day = ( $day == 0 ? 6 : $day - 1);
    */
    $doctorId = $request->input('doctor_id');
    return $scheduleService->getAvailableIntervals($date, $doctorId);
  }
}
