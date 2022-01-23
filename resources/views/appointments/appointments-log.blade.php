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
          <a href="{{ url('/appointments/'.$appointment->id) }}" class="btn btn-primary btn-sm">Ver</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="card-body">
   {{ $mainData->links() }}
</div>