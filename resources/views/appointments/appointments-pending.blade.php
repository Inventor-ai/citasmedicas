<div class="table-responsive">
  <table class="table align-items-center table-flush">
    @include('appointments.appointments-thead')
    <tbody>
      @foreach ($mainData as $appointment)
      <tr>
        @include('appointments.appointments-tbody')
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
          {{-- @if ($role != 'patient') --}}
          @if ($role == 'doctor')
              <form method="POST" class="d-inline-block"
                action="{{url('/appointments/'.$appointment->id.'/confirmar')}}">
                @csrf
                <button type="submit" class="btn btn-sm btn-success" title="Confirmar cita"
                  data-toggle="tooltip"><i class="ni ni-check-bold"></i></button>
              </form>
          @endif
          {{-- Route::post('/appointments/{appointment}/cancel', 'AppointmentController@cancel'); --}}
          <form method="POST" class="d-inline-block"
            action="{{url('/appointments/'.$appointment->id.'/cancel')}}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger" title="Cancelar cita"
              data-toggle="tooltip"><i class="ni ni-fat-remove"></i></button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="card-body">
   {{ $mainData->links() }}
</div>