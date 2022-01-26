@extends('layouts.list')
<?php
  $mainTitle = $role == 'admin' ? 'Citas médicas' : 'Mis citas';
  $mainRoute = 'appointments';
?>
@section('title', "$mainTitle")

@section('TabSection')
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link @yield('active-confirmed')" role="tab"
         href="{{ url("/$mainRoute") }}" aria-selected="true">
         Mis próximas citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link @yield('active-pending')" role="tab"
         href="{{ url("/$mainRoute/pending") }}" aria-selected="false">
         Citas por confirmar
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link @yield('active-log')" role="tab"
         href="{{ url("/$mainRoute/log") }}" aria-selected="false">
         Historial de citas
      </a>
    </li>
  </ul>
@endsection
