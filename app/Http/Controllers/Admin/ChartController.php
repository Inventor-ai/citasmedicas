<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\User;
use DB;

class ChartController extends Controller
{
  public function appointments()
  {
    // dd( Appointment::all()); 
    // dd( Appointment::groupBy('MONTH(created_at)'));
    // dd( 
    // //    Appointment::groupBy(DB::raw('MONTH(created_at)'))->get()  // No jaló
    //    Appointment::select(DB::raw('MONTH(created_at) as month'))->
    //    groupBy('month')->get()
    // );

    // dd( 
    //    Appointment::select(DB::raw('MONTH(created_at) as month'))->
    //    groupBy('month')->get()->toArray()
    // );

    // dd(
    //    Appointment::select(
    //        DB::raw('MONTH(created_at) as month'), 
    //        DB::raw('COUNT(1)')
    //    )->groupBy('month')->get()->toArray()
    // );

    $monthlyCounts = Appointment::select(
                        DB::raw('MONTH(created_at) as month'), 
                        DB::raw('COUNT(0) as count')
                     )->groupBy('month')->get()->toArray();
    // dd($monthlyCounts);
    // [ ['month =>1,  'COUNT(0)' => 22],
    //   ['month =>12, 'COUNT(0)' =>  1], ] Result
    // [22, 0, 0, 0, 0,..., 0, 1]           Goal
    $counts = array_fill(0, 12, 0 );  // start_index, num, value / index, Qty, value
    // dd($counts);
    foreach ($monthlyCounts as $monthlyCount) {
      $counts[$monthlyCount['month']-1] = $monthlyCount['count'];
    }
    // dd($counts);
    return view("charts.appointments", compact('counts'));
  }

  public function doctors()
  {
    // dd();
    return view("charts.doctors");
    return view("charts.doctors", compact('counts'));
  }
  
  public function doctorsJson()
  {
    $doctors = User::doctors()
                   ->select(['id', 'name'])
                   ->withCount('asDoctorAppointments')
                   ->orderBy('as_doctor_appointments_count', 'desc')
                   ->take(5)
                   ->get()
                   ->toArray();
    dd( $doctors );
    $data = [];
    $data['categories'] = User::doctors()->pluck('name');
    $series             = [];
    $series1            = 1;  // Atendidas
    $series2            = 2;  // Canceladas
    $series[]           = $series1;
    $series[]           = $series2;
    $data['series']     = $series;
    return $data; // [categories: ['A', 'B']. series: [1, 2]]
  }
}
