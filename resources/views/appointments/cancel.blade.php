@extends('layouts.panel')
<?php
  // $mainTitle = "Cita # $appointment->id";
  $mainRoute = 'appointments';
?>
@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">

  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Cancelar cita</h3>
      </div>
    </div>
  </div>

  <div class="card-body">
    @if ($role == 'patient')
      <p>
        Estás a punto de cancelar tu cita reservada con el médico {{ $appointment->doctor->name }}
        (especialidad  {{ $appointment->specialty->name }} ) para día {{ $appointment->schedule_date }}
        a las {{ $appointment->scheduled_time_12 }}
      </p>
    @elseif ($role == 'doctor')
      <p>
        Estás a punto de cancelar tu cita 
        con paciente {{ $appointment->patient->name }}
        quien manifestó: {{ $appointment->description }} y desea atención
        de la especialidad: {{ $appointment->specialty->name }}
        para el día {{ $appointment->schedule_date }}
        a las {{ $appointment->scheduled_time_12 }}
      </p>
    @else
      <p>
        Estás a punto de cancelar la cita reservada 
        para el día {{ $appointment->schedule_date }}
        a las {{ $appointment->scheduled_time_12 }}
        con el médico {{ $appointment->doctor->name }}
        (especialidad  {{ $appointment->specialty->name }} ) 
        por paciente {{ $appointment->patient->name }}
        que menifestó: {{ $appointment->description }}
      </p>
    @endif
    {{-- <form action="{{url('/appointments/'.$appointment->id.'/cancel')}}" method="POST"> --}}
    <form action="{{url("/$mainRoute/$appointment->id/cancel")}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="justification">Por favor cuéntanos el motivo de la cancelación:</label>
        <textarea required name="justification" id="justification" class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-danger">Cancelar cita</button>
      {{-- <a href="{{ url('/appointments') }}" class="btn btn-primary"> --}}
      <a href="{{ url("/$mainRoute$tabName") }}" class="btn btn-primary">
        No cancelar y volver a listado de citas
      </a>
    </form>
  </div>
</div>
@endsection
