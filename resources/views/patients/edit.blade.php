@extends('layouts.userform')

@section('userAction', 'Editar paciente')
@section('userType', 'paciente')
@section('routeCancel', url('patients') )
@section('routeAction', url('patients/'.$patient->id) )
@section('put')@method('PUT')@endsection
@section('name')value="{{ old('name', $patient->name) }}" required @endsection
@section('email')value="{{ old('email', $patient->email) }}" required @endsection
@section('identity_card')value="{{ old('identity_card', $patient->identity_card) }}"@endsection
@section('phone')value="{{ old('phone', $patient->phone) }}"@endsection
@section('address')value="{{ old('address', $patient->address) }}"@endsection
