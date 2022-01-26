@extends('appointments.index')
<?php
  $mainItem = 'cita';
  $mainData = $appointments;
  $tabName  = 'log';
  $page     = $page ? "&$page" : "";
  $tabName  = "?tabName=$tabName$page";
?>

@section('active-log', 'active')

@section('tableData')
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pending-appointments" role="tabpanel" aria-labelledby="pxills-profile-tab">
      <div class="table-responsive">
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              {{-- <th scope="col">Descripción</th> --}}
              <th scope="col">Especialidad</th>
              {{-- <th scope="col">Médico</th> --}}
              <th scope="col">Fecha</th>
              <th scope="col">Hora</th>
              {{-- <th scope="col">Tipo</th> --}}
              <th scope="col">Estado</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($mainData as $appointment)
            <tr>
              <td scope="row">
                {{-- {{ $appointment ->description }}
              </td>
              <td> --}}
                {{ $appointment->specialty->name }}
              </td>
              {{-- <td>
                {{ $appointment->doctor->name }}
              </td> --}}
              <td>
                {{ $appointment->schedule_date }}
              </td>
              <td>
                {{ $appointment->scheduled_time_12 }}
              </td>
              {{-- <td>
                {{ $appointment->type }}
              </td> --}}
              <td>
                {{ $appointment->status }}
              </td>
              <td>
                @include('appointments.tables.buttonShow')
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-body">
         {{ $mainData->links() }}
      </div>
    </div>
@endsection
