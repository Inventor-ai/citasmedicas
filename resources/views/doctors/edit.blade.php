@extends('layouts.userform')

@section('userAction', 'Editar médico')
@section('userType', 'médico')
@section('routeCancel', url('doctors') )
@section('routeAction', url('doctors/'.$doctor->id) )
@section('put')@method('PUT')@endsection
@section('name')value="{{ old('name', $doctor->name) }}" required @endsection
@section('email')value="{{ old('email', $doctor->email) }}" required @endsection
@section('identity_card')value="{{ old('identity_card', $doctor->identity_card) }}"@endsection
@section('phone')value="{{ old('phone', $doctor->phone) }}"@endsection
@section('address')value="{{ old('address', $doctor->address) }}"@endsection
