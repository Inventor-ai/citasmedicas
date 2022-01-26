@extends('appointments.index')
<?php
  $mainItem = 'cita';
  $mainData = $appointments;
  $tabName  = 'pending';
  $page     = $page ? "&$page" : "";
  $tabName  = "?tabName=$tabName$page";
?>

@section('active-pending', 'active')

@section('tableData')
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pending-appointments" role="tabpanel" aria-labelledby="pxills-profile-tab">
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
                {{-- @if ($role == 'doctor' || $role == 'admin') <!-- Video Version -->  --}}
                @if ($role != 'patient')
                    <form method="POST" class="d-inline-block"
                      action="{{url('/appointments/'.$appointment->id.'/confirm')}}">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-success" title="Confirmar {{$mainItem}}"
                        data-toggle="tooltip"><i class="ni ni-check-bold"></i></button>
                    </form>
                    @include('appointments.tables.buttonCancel')
                @else
                    <form method="POST" class="d-inline-block"
                      action="{{url('/appointments/'.$appointment->id.'/cancel')}}">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-danger" title="Cancelar {{$mainItem}}"
                        data-toggle="tooltip"><i class="ni ni-fat-remove"></i></button>
                    </form>
                @endif
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
