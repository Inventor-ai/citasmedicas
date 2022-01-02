@extends('layouts.list')

@section('title', 'Médicos')

@section('createRoute', url('doctors/create') )
@section('createText', 'Nuevo médico')
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
        @foreach ($doctors as $doctor)
        <tr>
          <th scope="row">
            {{ $doctor ->name }}
          </th>
            <td>
            {{ $doctor ->email }}
            </td>
            <td>
            {{ $doctor ->identity_card }}
            </td>
          <td>
            <form method="POST" action="{{url('/doctors/'.$doctor->id.'')}}">
              @csrf
              @method('DELETE')
              <a href="{{url('/doctors/'.$doctor->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
@endsection
