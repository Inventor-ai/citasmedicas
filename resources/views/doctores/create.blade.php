@extends('users.userCreate')
<?php
  $mainItem  = 'médico+';
  $mainRoute = 'doctores';

?>
@include("$mainRoute.specialties")

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
