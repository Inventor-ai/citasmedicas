{{-- Navigation --}}
<h6 class="navbar-heading text-muted">
  @if(auth()->user()->role == 'admin')
     Gestionar datos
  @else
     menu
  @endif
</h6>
<ul class="navbar-nav">
{{-- 
  @if(auth()->user()->role == 'admin')
    @include('includes.panel.menu.admin')
  @elseif( auth()->user()->role == 'doctor')
    @include('includes.panel.menu.doctor')
  @else
    @include('includes.panel.menu.patient')
  @endif 
--}}
  @include('includes.panel.menu.'. auth()->user()->role)
  <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
       document.getElementById('formlogout').submit();">
      <i class="ni ni-key-25"></i> Cerrar sesión
    </a>
    <form id="formlogout" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
  </li>
</ul>
@if(auth()->user()->role == 'admin')
  {{-- Divider --}}
  <hr class="my-3">
  {{-- Heading --}}
  <h6 class="navbar-heading text-muted">Reportes</h6>
  {{-- Navigation --}}
  <ul class="navbar-nav mb-md-3">
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="ni ni-sound-wave text-yellow"></i> Frecuencia de citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="ni ni-spaceship text-orange"></i> Médicos más activos
      </a>
    </li>
  </ul>
@endif
