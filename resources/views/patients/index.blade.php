@extends('layouts.panel')

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Pacientes</h3>
      </div>
      <div class="col text-right">
         <a href="{{ url('patients/create')}}" class="btn btn-sm btn-success">Nuevo paciente</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    @if( session('notification') )
    <div class="alert alert-success" role="alert">
      {{ session('notification') }}
    </div>
    @endif
  </div>
  <div class="table-responsive"> <!-- Specialities table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">E-mail</th>
          <th scope="col">Identificación</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($patients as $patient)
        <tr>
          <th scope="row">
            {{ $patient ->name }}
          </th>
            <td>
            {{ $patient ->email }}
            </td>
            <td>
            {{ $patient ->identity_card }}
            </td>
          <td>
            <form method="POST" action="{{url('/patients/'.$patient->id.'')}}">
              @csrf
              @method('DELETE')
              <a href="{{url('/patients/'.$patient->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
