@extends('layouts.list')
<?php
  $mainTitle = "Cita # $appointment->id";
  // $mainItem  = '';
  $mainRoute = 'appointments';
  $mainData  = $appointment;
?>
@section('title', "$mainTitle")

@section('TabSection')
  <ul>
    <li>
      <strong>Fecha:</strong> {{ $appointment->schedule_date }}
    </li>
    <li>
      <strong>Hora:</strong> {{ $appointment->schedule_time }}
    </li>
    <li>
      <strong>Estado:</strong> {{ $appointment->status }}
    </li>
    <li>
      <strong>Médico:</strong> {{ $appointment->doctor->name }}
    </li>
    <li>
      <strong>Especialidad:</strong> {{ $appointment->specialty->name }}
    </li>
    <div class="alert alert-warning">
        <p>Acerca de la cancelación:</p>
        <ul>
          @if ($appointment->cancellation)
             <li>
               <strong>Fecha de cancelación:</strong> 
               {{ $appointment->cancellation->created_at }}
             </li>
             <li>
               <strong>¿Quién canceló la cita?:</strong> 
               {{ $appointment->cancellation->canceled_by }}
             </li>
             <li>
               <strong>Justificación:</strong> 
               {{ $appointment->cancellation->justification }}
             </li>
          @else
            <li>Esta cita fue cancelada antes de su confirmación</li>
          @endif
        </ul>
    </div>
  </ul>
  <a href="{{ url('/appointments') }}" class="btn btn-default btn-sm">Volver</a>
@endsection
