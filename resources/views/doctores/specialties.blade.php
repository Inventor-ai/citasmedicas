@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('occupation')
  <div class="form-group">
    <label for="specialties">Especialidad</label>
    <select name="specialties[]" id="specialties" title="Seleccionar una o más" multiple
      class="form-control selectpicker show-tick" data-style="btn-outline-primary">
      @foreach ($specialties as $specialty)
         <option value="{{$specialty->id}}">{{$specialty->name}}</option>
      @endforeach
    </select>
  </div>
@endsection
