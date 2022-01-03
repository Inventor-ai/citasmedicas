@extends('layouts.panel')

@section('module', 'PANEL DE ADMINISTRACIÓN')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">@yield('title')</h3>
      </div>
      <div class="col text-right">
         <a href="@yield('createRoute')" class="btn btn-sm btn-success">@yield('createText')</a>
      </div>
    </div>
  </div>
  <div class="card-body">
    @if( session('notification') )
    <div class="alert alert-success" role="alert">
      {{ session('notification') }}
    </div>
    @endif
  </div>
  <div class="table-responsive">
    @yield('tableData')
  </div>
  <div class="card-body">
    {{ $mainData->links() }}
  </div>
</div>
@endsection
