<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
   protected $fillable = [
      'description',
      'specialty_id',
      'doctor_id',
      'patient_id',
      'schedule_date',
      'schedule_time',
      'type'
   ];
}
