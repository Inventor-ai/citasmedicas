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
    <form action="@yield('routeAction')" method="post">
      @csrf
      @yield('put')
      <div class="form-group">
        <label for="name">Especialidad</label>
        <select class="form-control" name="specialty_id" id="specialty" required>
          <option value="0">Elegir una especialidad</option>
          @foreach ($specialties as $Specialty)
            <option value="{{ $Specialty->id }}">{{ $Specialty->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="doctor">Médico</label>
        <select class="form-control" name="doctor_id" id="doctor">
           
        </select>
      </div>
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
            </div>
            <input class="form-control datepicker" placeholder="Select date"
              id="date" type="text" value="{{ date('Y-m-d') }}"
              data-date-format="yyyy-mm-dd" 
              data-date-start-date="{{ date('Y-m-d') }}" 
              data-date-end-date="+8d"
            >
        </div>
      </div>
      <div class="form-group">
        <label for="identity_card">Hora de atención</label>
        <div id="hours">
            <input type="text" id="identity_card" name="identity_card" class="form-control" @yield('identity_card')>
        </div>
      </div>
      <div class="form-group">
        <label for="phone">Teléfono / Móvil</label>
        <input type="text" id="phone" name="phone" class="form-control" @yield('phone')>
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