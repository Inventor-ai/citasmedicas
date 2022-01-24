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
      {{-- <strong>Paciente:</strong> {{ $appointment->patient->name }} --}}
      @if ($role == 'doctor')
          <strong>Paciente:</strong> {{ $appointment->patient->name }}
      @elseif ($role == 'patient')
          <strong>Médico:</strong> {{ $appointment->doctor->name }}
      @endif
    </li>
    {{-- <li>
        <strong>Médico:</strong> {{ $appointment->doctor->name }}
    </li> --}}
    <li>
      <strong>Especialidad:</strong> {{ $appointment->specialty->name }}
    </li>
    <li>
      <strong>Cita para:</strong> {{ $appointment->type }}
    </li>
    <li>
      <strong>Estado:</strong> 
      @if ($appointment->status == 'Cancelada')
        <span class="badge badge-danger">
          {{ $appointment->status }}
        </span>
      @else         
        <span class="badge badge-success">
           {{ $appointment->status }}
        </span>      
      @endif
    </li>
  </ul>
  <div class="alert alert-warning">
      <p>Acerca de la cancelación:</p>
      <ul>
        @if ($appointment->cancellation)
          <li>
            <strong>Fecha de cancelación:</strong> 
            {{ $appointment->cancellation->created_at }}
          </li>
          <li>
            {{-- <strong>Cita cancelada por:</strong>  --}}
            <strong>¿Quién canceló la cita?:</strong> 
            @if (auth()->user()->id == $appointment->cancellation->canceled_by_id)
                Tú
            @else
                {{ $appointment->cancellation->canceled_by->name }}
            @endif
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
  <a href="{{ url('/appointments') }}" class="btn btn-default btn-sm">Volver</a>
@endsection
