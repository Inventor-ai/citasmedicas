@extends('users.userform')
@section('userAction', "Nuevo $mainItem")
@section('userType', $mainItem)
@section('routeCancel', url("$mainRoute") )
@section('routeAction', url("$mainRoute") )

@section('name')value="{{ old('name') }}" required @endsection
@section('email')value="{{ old('email') }}" required @endsection
@section('password')value="{{ Str::random(6) }}" required @endsection
@section('identity_card')value="{{ old('identity_card') }}"@endsection
@section('phone')value="{{ old('phone') }}"@endsection
@section('address')value="{{ old('address') }}"@endsection
