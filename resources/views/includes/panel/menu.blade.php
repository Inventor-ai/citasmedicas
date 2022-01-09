{{-- Navigation --}}
<h6 class="navbar-heading text-muted">
  @if(auth()->user()->role == 'admin')
     Gestionar datos
  @else
     menu
  @endif
</h6>
<ul class="navbar-nav">
  @if(auth()->user()->role == 'admin')
    <li class="nav-item">
      <a class="nav-link" href="{{url('/home')}}">
        <i class="ni ni-tv-2 text-danger"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/specialties')}}">
        <i class="ni ni-planet text-blue"></i> Especialidades
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/users')}}">
        <i class="ni ni-single-02 text-orange"></i> Administradores
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/doctors')}}">
        <i class="ni ni-single-02 text-orange"></i> Médicos
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/doctores')}}">
        <i class="ni ni-single-02 text-orange"></i> Médicos+
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/patients')}}">
        <i class="ni ni-satisfied text-info"></i> Pacientes
      </a>
    </li>
  @elseif( auth()->user()->role == 'doctor')
    <li class="nav-item">
      <a class="nav-link" href="{{url('/schedule')}}">
        <i class="ni ni-calendar-grid-58 text-danger"></i> Gestionar hoario
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/schedule')}}">
        <i class="ni ni-time-alarm text-primary"></i> Mis citas
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/specialties')}}">
        <i class="ni ni-satisfied text-info"></i> Mis pacientes
      </a>
    </li>
  @else {{-- patient --}}
    <li class="nav-item">
      <a class="nav-link" href="{{url('/appointment/create')}}">
        <i class="ni ni-laptop text-danger"></i> Reservar cita
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/specialties')}}">
        <i class="ni ni-planet text-blue"></i> Mis citas
      </a>
    </li>
  @endif
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
