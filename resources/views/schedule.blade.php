@extends('layouts.panel')

@section('content')
  <form action="{{ url('/schedule') }}" method="POST">
    @csrf
    <div class="card shadow">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Gestionar horario </h3>
          </div>
          <div class="col text-right">
            <button type="submit" class="btn btn-sm btn-success">Guardar cambios</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        @if( session('notification') )
        <div class="alert alert-success" role="alert">
          {{ session('notification') }}
        </div>
        @endif
        @if( session('errors') )
        <div class="alert alert-danger" role="alert">
          Datos guardados, pero con incongruencias:
          <ul>
            @foreach ( session('errors')  as $error )
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
      </div>
      <div class="table-responsive">
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col">Día</th>
              <th scope="col">Activo</th>
              <th scope="col">Turno matutino</th>
              <th scope="col">Turno vepertino</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($workDays as $key => $workDay)
              <tr>
                <th>{{ $days[$key] }}</th>
                <td>
                  <label class="custom-toggle">
                      <input type="checkbox" name="active[]" value="{{$key}}"
                        {{ $workDay['active'] == 1 ? 'checked' : '' }}>
                      <span class="custom-toggle-slider rounded-circle"></span>
                  </label>
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-control" name="morning_start[]" style="text-transform: lowercase;">
                        @foreach ($turn1st as $option)
                          {{$workDayTime = $workDay->morning_start}}
                          @include('includes.option')
                        @endforeach
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="morning_end[]" style="text-transform: lowercase;">
                        @foreach ($turn1st as $option)
                           {{$workDayTime = $workDay->morning_end}}
                           @include('includes.option')
                        @endforeach
                      </select>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-control" name="afternoon_start[]" style="text-transform:lowercase;">
                        @foreach ($turn2nd as $option)
                           {{$workDayTime = $workDay->afternoon_start}}
                           @include('includes.option')
                        @endforeach
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="afternoon_end[]" style="text-transform: lowercase;">
                        @foreach ($turn2nd as $option)
                           {{$workDayTime = $workDay->afternoon_end}}
                           @include('includes.option')
                        @endforeach
                      </select>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>
@endsection
