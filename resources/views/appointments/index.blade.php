@extends('layouts.list')
<?php
  $mainTitle = 'Mis citas';
  // $mainItem  = '';
  $mainRoute = 'appointments';
  $mainData  = $appointments;
?>
@section('title', "$mainTitle")

@section('tableData')
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Descripción</th>
          <th scope="col">Especialidad</th>
          <th scope="col">Médico</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Estado</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($mainData as $appointment)
        <tr>
          <th scope="row">
            {{ $appointment ->description }}
          </th>
            <td>
              {{ $appointment ->specialty->name }}
            </td>
            <td>
              {{ $appointment ->doctor->name }}
            </td>
            <td>
              {{ $appointment ->schedule_date }}
            </td>
            <td>
              {{ $appointment ->scheduled_time_12 }}
            </td>
            <td>
              {{ $appointment ->type }}
            </td>
            <td>
              {{ $appointment ->status }}
            </td>
          <td>
            <form method="POST" action="{{url('/appointments/'.$appointment->id.'')}}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" title="Cancelar cita">
                  Cancelar
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
@endsection
