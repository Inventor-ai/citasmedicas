@extends('layouts.list')
<?php
  $mainTitle = 'Usuarios';
  $mainItem  = 'usuario';
  $mainRoute = 'users';
//   $mainData  = $mainData;
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
          <th scope="col">Rol</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($mainData as $user)
        <tr>
          <th scope="row">
            {{ $user ->name }}
          </th>
          <td>
            {{ $user ->email }}
          </td>
          <td>
            {{ $user ->role }}
          </td>
          <td>
            <form method="POST" action="{{url("/$mainRoute/$user->id")}}">
              @csrf
              @method('DELETE')
              <a href="{{url("/$mainRoute/$user->id/edit")}}" class="btn btn-sm btn-primary">Editar</a>
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
@endsection
