@extends('layouts.panel')

@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Nuevo médico</h3>
      </div>
      <div class="col text-right">
         <a href="{{ url('doctors')}}" class="btn btn-sm btn-default">Cancelar y volver</a>
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
    <form action="{{ url('doctors')}}" method="post">
      @csrf
      <div class="form-group">
        <label for="name">Nombre del médico</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <div class="form-group">
        <label for="specialties">Especialidad</label>
        <select name="specialties[]" id="specialties"  title="Seleccionar una o más"
          class="form-control selectpicker show-tick" data-style="btn-outline-primary" multiple>
          @foreach ($specialties as $Specialty)
            <option value="{{ $Specialty->id }}">{{ $Specialty->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}">
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="text" id="password" name="password" class="form-control" value="{{ Str::random(6) }}">
      </div>
      <div class="form-group">
        <label for="identity_card">Identificación</label>
        <input type="text" id="identity_card" name="identity_card" class="form-control" value="{{ old('identity_card') }}">
      </div>
      <div class="form-group">
        <label for="phone">Teléfono / Móvil</label>
        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
      </div>
      <div class="form-group">
        <label for="address">Dirección</label>
        <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}">
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>      
    </form>
  </div>
</div>
@endsection

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
