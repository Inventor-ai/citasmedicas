@extends('appointments.index')
<?php
  $mainItem = 'cita';
  $mainData = $appointments;
  $tabName  = $page ? "?$page" : ""; // $tabName  = ''; // confirmed'
?>

@section('active-confirmed', 'active')

@section('tableData')
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="confirmed-appointments" role="tabpanel" aria-labelledby="pills-home-tab">
      <div class="table-responsive">
        <table class="table align-items-center table-flush">
          @include('appointments.tables.thead')
          <tbody>
            @foreach ($mainData as $appointment)
            <tr>
              @include('appointments.tables.tbody')
              <td>
                @if ($role == 'admin')
                    @include('appointments.tables.buttonShow')
                @endif
                @include('appointments.tables.buttonCancel')
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
