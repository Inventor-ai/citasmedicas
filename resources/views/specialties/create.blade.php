@extends('layouts.panel')

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Nueva especialidad</h3>
      </div>
      <div class="col text-right">
         <a href="{{ url('specialties')}}" class="btn btn-sm btn-default">Cancelar y volver</a>
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
    <form action="{{ url('specialties')}}" method="post">
      @csrf
      <div class="form-group">
        <label for="name">Nombre de la especialidad</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <div class="form-group">
        <label for="description">Descripción de la especialidad</label>
        <input type="text" id="description" name="description" class="form-control" value="{{ old('description') }}">
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>      
    </form>
  </div>
</div>
@endsection
