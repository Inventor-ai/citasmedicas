@extends('layouts.list')
<?php
  $mainTitle = 'Mis citas';
  // $mainItem  = '';
  $mainRoute = 'appointments';
  // $mainData  = $appointments;
?>
@section('title', "$mainTitle")

@section('TabSection')
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" role="tab"
         href="#confirmed-appointments" aria-selected="true">
         Mis próximas citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" role="tab"
         href="#pending-appointments" aria-selected="false">
         Citas por confirmar
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" role="tab"
         href="#log-appointments" aria-selected="false">
         Historial de citas
      </a>
    </li>
  </ul>
@endsection

@section('tableData')
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="confirmed-appointments" role="tabpanel" aria-labelledby="pills-home-tab">
      <?php $mainData  = $appointmentsConfirmed; ?>
      @include('appointments.appointments-confirmed')
    </div>
    <div class="tab-pane fade" id="pending-appointments" role="tabpanel" aria-labelledby="pxills-profile-tab">
      <?php $mainData  = $appointmentsPending; ?>
      @include('appointments.appointments-pending')
    </div>
    <div class="tab-pane fade" id="log-appointments" role="tabpanel" aria-labelledby="pxills-profile-tab">
      <?php $mainData  = $appointmentsLog; ?>
      @include('appointments.appointments-log')
    </div>
  </div>
@endsection
