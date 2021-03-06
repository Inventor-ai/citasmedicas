@extends('layouts.panel')

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Nuevo @yield('user')</h3>
      </div>
      <div class="col text-right">
        
         <a href="@yield('route')" class="btn btn-sm btn-default">Cancelar y volver</a>
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
    <form action="{{ url('patients')}}" method="post">
      @csrf
      @hasSection('put')
      @method('PUT')
      @endif
      @hasSection('delete')
      @method('DELETE')
      @endif
      @yield('METHOD')
      <div class="form-group">
        <label for="name">Nombre del @yield('user')</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="text" id="password" name="password" class="form-control" value="{{ old('password') }}" required>        
        @hasSection('METHOD')
        <p>Ingresarla sólo si desea modificar la contraseña actual</p>
        @endif
      </div>
      <div class="form-group">
        <label for="indentity_card">Identificación</label>
        <input type="text" id="indentity_card" name="indentity_card" class="form-control" value="{{ old('indentity_card') }}">
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
