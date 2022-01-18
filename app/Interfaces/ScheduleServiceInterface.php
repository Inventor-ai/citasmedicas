<?php 
namespace App\Interfaces;

use Carbon\Carbon;

interface ScheduleServiceInterface
{
    public function getAvailableIntervals($date, $doctorId);
    
    public function isAvailableInterval($doctorId, $date, Carbon $time);
}