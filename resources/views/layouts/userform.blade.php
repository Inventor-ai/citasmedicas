@extends('layouts.panel')

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">@yield('userAction')</h3>
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
        <label for="name">Nombre del @yield('userType')</label>
        <input type="text" id="name" name="name" class="form-control" @yield('name')>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="form-control" @yield('email')>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="text" id="password" name="password" class="form-control" @yield('password')>
        @hasSection('put')
        <p>Ingresarla sólo para modificar la contraseña actual</p>
        @endif
      </div>
      <div class="form-group">
        <label for="identity_card">Identificación</label>
        <input type="text" id="identity_card" name="identity_card" class="form-control" @yield('identity_card')>
      </div>
      <div class="form-group">
        <label for="phone">Teléfono / Móvil</label>
        <input type="text" id="phone" name="phone" class="form-control" @yield('phone')>
      </div>
      <div class="form-group">
        <label for="address">Dirección</label>
        <input type="text" id="address" name="address" class="form-control" @yield('address')>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>      
    </form>
  </div>
</div>
@endsection
