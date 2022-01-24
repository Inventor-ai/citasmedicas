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
            @if ($role == 'doctor')
                {{ $appointment ->patient->name }}
            @elseif ($role == 'patient')
                {{ $appointment ->doctor->name }}
            @endif
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

          {{-- <td>
            {{ $appointment ->status }}
          </td> --}}
        {{-- @include('appointments.appointments-data') --}}
        <td>
          <a class="btn btn-sm btn-danger" title="Cancelar cita"
             href="{{url('/appointments/'.$appointment->id.'/cancel')}}">
            Cancelar
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="card-body">
   {{ $mainData->links() }}
</div>