@extends('layouts.dashboard')

@section('navBarTitle','Carga de usuarios')

@section('navBarSalir') 
	<a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
@stop

@section('collapsedCM','')
@section('activeCM','active')
@section('indexCM')
	@include("inicio.cargamasiva")
@stop