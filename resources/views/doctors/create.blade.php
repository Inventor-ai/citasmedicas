@extends('layouts.userform')

@section('userAction', 'Nuevo médico')
@section('userType', 'médico')
@section('routeCancel', url('doctors') )
@section('routeAction', url('doctors') )

@section('name')value="{{ old('name') }}" required @endsection
@section('email')value="{{ old('email') }}" required @endsection
@section('password')value="{{ Str::random(6) }}" required @endsection
@section('identity_card')value="{{ old('identity_card') }}"@endsection
@section('phone')value="{{ old('phone') }}"@endsection
@section('address')value="{{ old('address') }}"@endsection
