<div class="table-responsive">
  <table class="table align-items-center table-flush">
    @include('appointments.tables.thead')
    <tbody>
      @foreach ($mainData as $appointment)
      <tr>
        @include('appointments.tables.tbody')
        {{-- <th scope="row">
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
          </td> --}}
          {{-- @include('appointments.appointments-data') --}}
          {{-- <td>
            {{ $appointment ->status }}
          </td> --}}
        <td>
          @if ($role == 'admin')
          @include('appointments.tables.buttonShow')
              {{-- <div class="d-inline-block">
              </div> --}}
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
              {{-- <a class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancelar {{$mainItem}}"
                 href="{{url('/appointments/'.$appointment->id.'/cancel')}}">
                 Cancelar
              </a> --}}
          @else
              <form method="POST" class="d-inline-block"
                action="{{url('/appointments/'.$appointment->id.'/cancel')}}">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger" title="Cancelar {{$mainItem}}"
                  data-toggle="tooltip"><i class="ni ni-fat-remove"></i></button>
              </form>

          @endif
          {{-- Route::post('/appointments/{appointment}/cancel', 'AppointmentController@cancel'); --}}
          {{-- <form method="POST" class="d-inline-block"
            action="{{url('/appointments/'.$appointment->id.'/cancel')}}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger" title="Cancelar {{$mainItem}}"
              data-toggle="tooltip"><i class="ni ni-fat-remove"></i></button>
          </form> --}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="card-body">
   {{ $mainData->links() }}
</div>