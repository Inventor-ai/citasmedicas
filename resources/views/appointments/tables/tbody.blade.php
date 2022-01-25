          <td scope="row">
            {{ $appointment ->description }}
          </td>
          <td>
            {{ $appointment ->specialty->name }}
          </td>
          @if ($role == 'doctor')
              <td>{{ $appointment ->patient->name }}</td>
          @elseif ($role == 'patient')
              <td>{{ $appointment ->doctor->name }}</td>
          @endif
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
  