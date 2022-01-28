<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Appointment::class, function (Faker $faker) {
   $doctorsIds  = User::doctors()->pluck('id');
   $patientsIds = User::patients()->pluck('id');
   $scheduleDT  = $faker->dateTimeBetween('-1 years', 'now'); // DateTime('2003-03-15 02:00:49')
   $date        = $scheduleDT->format('Y-m-d');
   // $time        = $scheduleDT->format('H:i:s'); // 
   $minutes     = $faker->randomElement(['00','30']);
   $time        = $dateTime->format('H').":$minutes:00";
   $types       = ['Consulta', 'Examen', 'Opreación']; // Falta: Vencida
   // $statuses    = ['Reservada', 'Confirmada', 'Cancelada', 'Atendida'];
   $statuses    = ['Cancelada', 'Atendida'];  // 'Reservada', 'Confirmada', 
   return [
    'description'   => $faker->sentence(5),
    'specialty_id'  => $faker->numberBetween(1, 5),
    'doctor_id'     => $faker->randomElement($doctorsIds),
    'patient_id'    => $faker->randomElement($patientsIds),
    'schedule_date' => $date,
    'schedule_time' => $time,
    'type'          => $faker->randomElement($types),
    'status'        => $faker->randomElement($statuses)
   ];
});
