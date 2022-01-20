@extends('layouts.list')
<?php
  $mainTitle = 'Pacientes';
  $mainItem  = 'paciente';
  $mainRoute = 'patients';
  $mainData  = $patients;
?>
@section('title', "$mainTitle")

@section('createRoute')
  <div class="col text-right">
    <a href="{{ url("$mainRoute/create") }}" class="btn btn-sm btn-success">{{ "Nuevo $mainItem" }}</a>
  </div>
@endsection

@section('tableData')
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
            <form method="POST" action="{{url("/$mainRoute/$patient->id")}}">
              @csrf
              @method('DELETE')
              <a href="{{url("/$mainRoute/$patient->id/edit")}}" class="btn btn-sm btn-primary">Editar</a>
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
@endsection
