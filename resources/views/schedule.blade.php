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
          Los cambios se han guardado pero debe tener en cuenta que:
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
              <th scope="col">Turno tarde</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($workDays as $key => $workDay)
              <tr>
                <th>{{ $days[$key] }}</th>
                <td>
                  <label class="custom-toggle">
                      <input type="checkbox" name="active[]" value="{{$key}}"
                        {{-- Video version --}}
                        {{-- @if( $workDay->active == 1 ) checked @endif --}}
                        {{-- Owner's version --}}
                        {{ $workDay['active'] == 1 ? 'checked' : '' }}
                      >
                      <span class="custom-toggle-slider rounded-circle"></span>
                  </label>
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-control" name="morning_start[]">
                        @for ($i=1; $i < 12; $i++)
                          <option value="{{ ($i < 10 ? '0':'').$i }}:00"
                          @if( $i.':00 AM' == $workDay->morning_start ) selected @endif >{{$i}}:00 am</option>
                          <option value="{{ ($i < 10 ? "0":"").$i }}:30"
                          @if( "$i:30 AM" == $workDay->morning_start ) selected @endif >{{$i}}:30 am</option>
                        @endfor
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="morning_end[]">
                        @for ($i=1; $i < 12; $i++)
                          <option value="{{ $i < 10 ? "0$i" : $i }}:00"
                          {{"$i:00 AM" == $workDay->morning_end ? "selected":""}}>{{$i}}:00 am</option>
                          {{-- @if( $i.':00 AM' == $workDay->morning_end ) selected @endif >{{$i}}:00 am</option> --}}
                          <option value="{{ $i < 10 ? "0$i" : $i }}:30"
                          {{"$i:30 AM" == $workDay->morning_end ? "selected":""}}>{{$i}}:30 am</option>
                          {{-- @if( "$i:30 AM" == $workDay->morning_end ) selected @endif >{{$i}}:30 am</option> --}}
                        @endfor
                      </select>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-control" name="afternoon_start[]">
                        @for ($i=1; $i < 12; $i++)
                          <option value="{{$i+12}}:00"
                          @if( $i.':00 PM' == $workDay->afternoon_start ) selected @endif >{{$i}}:00 pm</option>
                          <option value="{{$i+12}}:30"
                          @if( "$i:30 PM" == $workDay->afternoon_start ) selected @endif >{{$i}}:30 pm</option>
                        @endfor
                      </select>
                    </div>
                    <div class="col">
                      <select class="form-control" name="afternoon_end[]">
                        @for ($i=1; $i < 12; $i++)
                          <option value="{{$i+12}}:00"
                          @if( $i.':00 PM' == $workDay->afternoon_end ) selected @endif >{{$i}}:00 pm</option>
                          <option value="{{$i+12}}:30"
                          @if( "$i:30 PM" == $workDay->afternoon_end ) selected @endif >{{$i}}:30 pm</option>
                        @endfor
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
