@extends('layouts.list')

@section('title', 'Pacientes')

@section('createRoute', url('patients/create') )
@section('createText', 'Nuevo paciente')
@section('tableData')
    <div class="table-responsive">
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
@endsection
