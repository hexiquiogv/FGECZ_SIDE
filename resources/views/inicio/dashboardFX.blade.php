@extends('layouts.dashboard')

@section('navBarTitle')
Carga de Carga de Formulario de {{Auth::User()->name}}
 @stop
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

@section('collapsedFX','')
@section('activeFX','active')
@section('indexFX')
	@include("inicio.cargaExcel")
@stop