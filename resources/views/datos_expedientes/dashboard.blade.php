@extends('layouts.dashboard')

@section('navBarTitle','Datos Expediente')
@section('navBarListado') 
  @if(Auth::User()->TipoUsuario==1)
    <a class="dropdown-item" href='{{ route("listado") }}'>Inicio</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('dash',['rs']) }}">Carga de Formulario Excel</a>
	<div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('dash',['e3',0]) }}">Registro de causa penal de años anteriores</a>
    <div class="dropdown-divider"></div>
  @else
    <a class="dropdown-item" href='{{ route("listado.super") }}'>Inicio</a>
    <div class="dropdown-divider"></div>
    @if(Auth::User()->TipoUsuario!=2)
      <a class="dropdown-item" href='{{ route("estadistica.super") }}'>Apartado estadístico</a>
      <div class="dropdown-divider"></div>   
    @endif
  @endif
 @stop
@section('navBarSalir') 
	<a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
 @stop

@section('collapsedDE','')
@section('activeDE','active')
@section('indexDE') 
  @include("datos_expedientes.index")
@stop

@section('script')        
  <script>
    
    // document.querySelectorAll(".list-group-causa-penal").forEach(item => 
        // item.addEventListener("click", () =>{
            
            // if (item.id === "persona_judicializada_1") {
                // let tab = new bootstrap.Tab('#myTab button[data-bs-target="#detalle-persona-judicializada-1"]');
                // tab.show();
            // }
        // })
    // )

    // const triggerEl = document.querySelector('#myTab button[data-bs-target="#profile"]')

    // var tab = new bootstrap.Tab('#myTab button[data-bs-target="#profile"]');
    // tab.show();
    // bootstrap.Tab.getInstance(triggerEl).show() // Select tab by name


    // document.getElementById('myProfile').onclick = () => {

    // }
  </script>
 @stop