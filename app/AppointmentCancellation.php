<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class AppointmentCancellation extends Model
{
   public function canceled_by()  // canceled_by_id
   { // belongsTo Cancellation N - 1 User hasMany
     return $this->belongsTo(User::class);
   }
}
