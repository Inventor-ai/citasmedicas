@extends('layouts.list')
<?php
  $mainTitle = "Cita # $appointment->id";
  $mainRoute = 'appointments';
?>
@section('title', "$mainTitle")

@section('TabSection')
  <ul>
    <li>
      <strong>Fecha:</strong> {{ $appointment->schedule_date }}
    </li>
    <li>
      <strong>Hora:</strong> {{ $appointment->scheduled_time_12 }}
    </li>
    @if ($role == 'admin' || $role == 'patient')
      <li>
        <strong>Médico:</strong> {{ $appointment->doctor->name }}
      </li>
    @endif
    <li>
      <strong>Especialidad:</strong> {{ $appointment->specialty->name }}
    </li>
    @if ($role == 'admin' || $role == 'doctor')
      <li>
        <strong>Paciente:</strong> {{ $appointment->patient->name }}
      </li>
    @endif
    <li>
      <strong>Cita para:</strong> {{ $appointment->type }}
    </li>
    <li>
      <strong>Manifiesta:</strong> {{ $appointment->description }}
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
  @if ($appointment->status == "Cancelada")      
    <div class="alert alert-warning">
        <p>Acerca de la cancelación:</p>
        <ul>
            @if ($appointment->cancellation)
            <li>
                <strong>Fecha de cancelación:</strong> 
                {{ $appointment->cancellation->created_at }}
            </li>
            <li>
                <strong>Cita cancelada por:</strong> 
                {{-- <strong>¿Quién canceló la cita?:</strong> --}}
                @if ($appointment->cancellation->canceled_by_id == auth()->user()->id)
                    {{-- Tú --}}
                    Ti
                @elseif ($appointment->cancellation->canceled_by_id == $appointment->patient_id)
                    Paciente
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
  @endif
  <a href="{{ url("/$mainRoute$tabName") }}" class="btn btn-default btn-sm">Volver</a>
@endsection
