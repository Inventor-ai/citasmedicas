@extends('layouts.panel')

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Registrar nueva cita</h3>
      </div>
      <div class="col text-right">
         <a href="@yield('routeCancel')" class="btn btn-sm btn-default">Cancelar y volver</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    @if ($errors->any())
      <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif
    <form action="{{ url('/appointments') }}" method="post">
      @csrf
      <div class="form-group">
         <label for="description">Descripción</label>
         <input type="text" class="form-control" name="description" id="description"
           placeholder="Describe brevemente la consulta" required value="{{ old('description') }}">
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="name">Especialidad</label>
          <select class="form-control" name="specialty_id" id="specialty" required>
            <option value="0">Elegir una especialidad</option>
            @foreach ($specialties as $specialty)
              <option value="{{ $specialty->id }}"
                @if( old('specialty_id') == $specialty->id) selected @endif
              >{{ $specialty->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="doctor">Médico</label>
          <select class="form-control" name="doctor_id" id="doctor" required>
            @foreach ($doctors as $doctor)
            <option value="{{ $doctor->id }}"
              @if( old('doctor_id') == $doctor->id) selected @endif
            >{{ $doctor->name }}</option>
            @endforeach
          </select>    
        </div>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
            </div>
            <input class="form-control datepicker" placeholder="Seleccionar fecha" type="text"
              id="date" name="schedule_date" value="{{ old('schedule_date', date('Y-m-d')) }}"
              data-date-format="yyyy-mm-dd" 
              data-date-start-date="{{ date('Y-m-d') }}" 
              data-date-end-date="+{{$endDate}}d"
            >
        </div>
      </div>
      <div class="form-group">
        <label for="identity_card">Hora de atención</label>
        <div id="hours">
          @if ($intervals)
            @foreach ($intervals['morning'] as $key => $interval)
               <div class="custom-control custom-radio mb-3">
                <input type="radio" class="custom-control-input"
                   id="intervalMorning{{ $key }}" name="schedule_time" 
                value="{{ $interval['start'] }}" required>
                <label class="custom-control-label" for="intervalMorning{{ $key }}">
                  {{ $interval['start'] }} - {{ $interval['end'] }}
                </label>
              </div>
            @endforeach
            @foreach ($intervals['afternoon'] as $key => $interval)
               <div class="custom-control custom-radio mb-3">
                <input type="radio" class="custom-control-input"
                   id="intervalAfternoon{{ $key }}" name="schedule_time" 
                value="{{ $interval['start'] }}" required>
                <label class="custom-control-label" for="intervalAfternoon{{ $key }}">
                  {{ $interval['start'] }} - {{ $interval['end'] }}
                </label>
              </div>
            @endforeach
          @else
            <div class="alert alert-info" role="alert">
              Seleccionar un médico y una fecha para ver sus horas disponibles.
            </div>
          @endif
        </div>
      </div>
      <div class="form-group">
        <label for="type">Tipo de consulta</label>
        <div class="custom-control custom-radio mb-3">
           <input type="radio" class="custom-control-input"
               id="type1" name="type" 
               @if( old('type', 'Consulta') == "Consulta") checked @endif value="Consulta">
           <label class="custom-control-label" for="type1">Consulta</label>
        </div>
        <div class="custom-control custom-radio mb-3">
           <input type="radio" class="custom-control-input"
               id="type2" name="type"
               @if( old('type') == "Examen") checked @endif value="Examen">
           <label class="custom-control-label" for="type2">Examen</label>
        </div>
        <div class="custom-control custom-radio mb-3">
           <input type="radio" class="custom-control-input"
               id="type3" name="type"
               @if( old('type') == "Operación") checked @endif value="Operación">
           <label class="custom-control-label" for="type3">Operación</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>      
    </form>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{asset('/js/appointments/create.js')}}"></script>
@endsection
