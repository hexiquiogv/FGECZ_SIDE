@extends('layouts.dashboard')

@section('navBarTitle','Carga de usuarios')

@section('navBarSalir') 
	<a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
@stop

@section('collapsedAU','')
@section('activeAU','active')
@section('indexAU')
	@include("inicio.registration")
@stop