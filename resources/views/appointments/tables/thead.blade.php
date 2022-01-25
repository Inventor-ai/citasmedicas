      <thead class="thead-light">
        <tr>
          <th scope="col">Descripción</th>
          <th scope="col">Especialidad</th>
          @if ($role == 'doctor')
              <th scope="col">Paciente</th>
          @elseif ($role == 'patient')
              <th scope="col">Médico</th>
          @endif
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          {{-- <th scope="col">Estado</th> --}}
          <th scope="col">Opciones</th>
        </tr>
      </thead>
