@extends('users.userEdit')
<?php
  $mainItem  = 'médico+';
  $mainRoute = 'doctores';
  $mainData  = $doctore;
?>
@include("$mainRoute.specialties")

@section('scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
  $(document).ready( ()=> {
    $('#specialties').selectpicker('val', @json($specialties_ids));
  });
</script>
@endsection
