<?php 
namespace App\Services;
use App\Interfaces\ScheduleServiceInterface;
use App\WorkDay;
use App\Appointment;
use Carbon\Carbon;

class ScheduleService implements ScheduleServiceInterface
{
   public function isAvailableInterval($doctorId, $date, Carbon $time)
   {
     $exist = Appointment::where('doctor_id', $doctorId)
                         ->where('schedule_date', $date)
                         ->where('schedule_time', $time->format('H:i:s'))
                         ->Where('status', '!=', 'Cancelada')
                         ->exists();
     return !$exist; // available if already none exists
   }

   public function getAvailableIntervals($date, $doctorId)
   {
     $workDays = WorkDay::where('active', true)
                        ->where('day', $this->getDayFromDate($date))
                        ->where('user_id', $doctorId)
                        ->first([
                           'morning_start',   'morning_end',
                           'afternoon_start', 'afternoon_end'
                         ]
     );
        
     if (!$workDays) return [];

     $morningIntervals   = $this->getIntervals($workDays->morning_start, 
                                               $workDays->morning_end,
                                               $date, $doctorId);

     $afternoonIntervals = $this->getIntervals($workDays->afternoon_start, 
                                               $workDays->afternoon_end,
                                               $date, $doctorId);
     $data = [];
     $data['morning']   = $morningIntervals;
     $data['afternoon'] = $afternoonIntervals;
     return $data;
   }

   private function getDayFromDate($date)
   {
     $dateCarbon = new Carbon($date);
     $day = $dateCarbon->dayOfWeek;    
     // dayOfWeek
     // Carbon : 0 = sunday - 6 = saturday
     // WorkDay: 0 = monday - 6 = sunday
     return ( $day == 0 ? 6 : $day - 1);
   }

   private function getIntervals($start, $end, $date, $doctorId)
   {
     $start = new Carbon($start);
     $end   = new Carbon($end);
     $intervals = [];
     while ($start < $end) {
       $interval = [];
       $interval['start'] = $start->format('g:i A');
       $available = $this->isAvailableInterval($doctorId, $date, $start);
       $start->addMinutes(30);        
       $interval['end']   = $start->format('g:i A');
       if ( $available ) // If available: Add interval to list
            $intervals[] = $interval;
     }
     return $intervals;
   }

}
