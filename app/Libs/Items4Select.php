<?php

namespace App\Libs;

class Items4Select
{
  public static function getHoursList($from, $to, $am = true, $interval = [0, 30]) {
    $hours = [];
    $mins  = [];
    if ( $from < 0 || $from > 23) 
       return "$from is out of range. Valid range from: 0 to 23";
    if ( $to < 0 || $to > 23) 
       return "$to is out of range. Valid range from: 0 to 23";
    foreach ($interval as $value)
      $mins[] = $value < 10 ? "0$value" : "$value";
    for ($i = $from; $i <= $to; $i++) {
      $hr =$i + ($am? 0:12);
      if ($hr > ($am?11:23)) {
          if ($hr > 23)
              $hr = $hr - 24;
          $am = !$am;
      }
      if ($hr < 10) $hr = "0$hr";
      if ($i > 12 )
         $am = !$am;
      $amPm  = $am?"AM":"PM";
      foreach ($mins as $min) {
        $hours[] = array (
           'value' => "$hr:$min",
           'text'  => "$i:$min $amPm"
        );
      }
    }
    return $hours;
  }
}
