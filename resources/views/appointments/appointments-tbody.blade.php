          <td scope="row">
            {{ $appointment ->description }}
          </td>
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
          </td>
          {{-- <td>
            {{ $appointment ->status }}
          </td> --}}
  