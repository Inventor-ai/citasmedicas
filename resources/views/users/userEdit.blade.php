@extends('users.userForm')
@section('userAction', "Editar $mainItem")
@section('userType', $mainItem)
@section('routeCancel', url($mainRoute) )
@section('routeAction', url("$mainRoute/".$mainData->id) )

@section('put')@method('PUT')@endsection
@section('name')value="{{ old('name', $mainData->name) }}" required @endsection
@section('email')value="{{ old('email', $mainData->email) }}" required @endsection
@section('identity_card')value="{{ old('identity_card', $mainData->identity_card) }}"@endsection
@section('phone')value="{{ old('phone', $mainData->phone) }}"@endsection
@section('address')value="{{ old('address', $mainData->address) }}"@endsection
