<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Appointment;
use App\User;
use DB;

class ChartController extends Controller
{
  public function appointments()
  {
    $monthlyCounts = Appointment::select(
                        DB::raw('MONTH(created_at) as month'), 
                        DB::raw('COUNT(0) as count')
                     )->groupBy('month')->get()->toArray();
    $counts = array_fill(0, 12, 0 );  // start_index, num, value / index, Qty, value
    foreach ($monthlyCounts as $monthlyCount) {
      $counts[$monthlyCount['month']-1] = $monthlyCount['count'];
    }
    return view("charts.appointments", compact('counts'));
  }

  public function doctors()
  {
    $now   = Carbon::now();
    $end   = $now->format('Y-m-d');
    $start = $now->subYear()->format('Y-m-d');
    return view("charts.doctors", compact('start', 'end'));
  }

  public function doctorsJson(Request $request)
  {
    $startDate = $request->input('startDate');
    $endDate  = $request->input('endDate');
    $doctors = User::doctors()
                   ->select('name')
                   ->withCount([
                       'attendedAppointments' => function($query) use ($startDate, $endDate) {
                          $query->whereBetween('schedule_date', [$startDate, $endDate]);
                       },
                       'canceledAppointments' => function($query) use ($startDate, $endDate) {
                          $query->whereBetween('schedule_date', [$startDate, $endDate]);
                       }
                     ])
                   ->orderBy('attended_appointments_count', 'desc')
                   ->take(5)
                   ->get();
    $data = [];
    $data['categories'] = $doctors->pluck('name');
    $series               = [];
    $series1['name']      = 'Citas atendidas';
    $series1['data']      = $doctors->pluck('attended_appointments_count');
    $series2['name']      = 'Citas canceladas';
    $series2['data']      = $doctors->pluck('canceled_appointments_count');
    $series[]             = $series1;
    $series[]             = $series2;
    $data['series']       = $series;
    return $data; // [categories: ['A', 'B']. series: [1, 2]]
  }
  
}
