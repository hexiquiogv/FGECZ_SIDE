@extends('layouts.dashboard')

@section('navBarTitle')
Expedientes de {{Auth::User()->name}}
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
 @section('collapsedNT','')
 @section('activeNT','active')
 @section('collapsedLI','collapsed')
 @section('activeLI','')
 @section('collapsedLICC','collapsed')
 @section('activeLICC','')
 @section('collapsedLIND','collapsed')
 @section('activeLIND','') 
 @section('indexNT')
	@include("inicio.notificaciones") 
 @stop
 @section('indexLI')
	  <div class="accordion" id="accordionFiltrosExpedientes">
		<div class="accordion-item">
		  <h2 class="accordion-header" id="panelsFiltrosExpedientes">
			<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOneExpedientes" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneExpedientes">
			  Filtros
			</button>
		  </h2>
		  <div id="panelsStayOpen-collapseOneExpedientes" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosExpedientes">
	       <form method='post' id="frmListado" action="{{ route('listado') }}" enctype="multipart/form-data">
	        @csrf
			<div class="accordion-body row">
			 <input type="hidden" name="tipo" value="de">
			 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="id_expediente" class="form-label">ID de Expediente:</label>
			  <input type="text" class="form-control busqueda" name="id_expediente" id="id_expediente" placeholder="">
			 </div> -->
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="no_expediente" class="form-label">Número de Expediente:</label>
			  <input type="text" class="form-control busqueda" name="no_expediente" id="no_expediente" placeholder="">
			 </div>
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="nuc" class="form-label">N.U.C.:</label>
			  <input type="text" class="form-control busqueda" name="nuc" id="nuc" placeholder="">
			 </div>
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="no_causa" class="form-label">Causa:</label>
			  <input type="text" class="form-control busqueda" name="no_causa" id="no_causa" placeholder="">
			 </div>
			 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="nameDel" class="form-label">Nombre del delito:</label>
			  <input type="text" class="form-control busqueda" name="nameDel" id="nameDel">
			 </div> -->
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="nameImp" class="form-label">Nombre del imputado:</label>
			  <input type="text" class="form-control busqueda" name="nameImp" id="nameImp">
			 </div>
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="nameVic" class="form-label">Nombre de la víctima:</label>
			  <input type="text" class="form-control busqueda" name="nameVic" id="nameVic">
			 </div>
			 <div class="col-12"></div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6">
			  <label for="fechaInicio" class="form-label">Fecha de inicio de carpeta:</label>
			  <div class="input-group">
				<label for="fechaInicio" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaInicio" id="fechaInicio">			  
				<label for="fechaFin" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaFin" id="fechaFin">
			  </div>
			 </div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6 d-none">
			  <label for="fechaRegistrosD" class="form-label">Fecha de registro:</label>
			  <div class="input-group">
				<label for="fechaRegistrosD" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaRegistrosD" id="fechaRegistrosD">
				<label for="fechaRegistrosH" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaRegistrosH" id="fechaRegistrosH">
			  </div>
			 </div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6">
			  <label for="fechaHechosD" class="form-label">Fecha de los hechos:</label>
			  <div class="input-group">
				<label for="fechaHechosD" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaHechosD" id="fechaHechosD">
				<label for="fechaHechosH" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaHechosH" id="fechaHechosH">
			  </div>
			 </div>			 			 
			 <div class="d-flex align-items-end mb-3 col-sm-12 col-md-6">
			  <input type="hidden" name="filtroListado" id="filtroListado"> 
			  <button type="button" onclick="javascript:buscar('frmListado')" class="btn btn-primary btn-sm">Buscar</button>
			  &nbsp;&nbsp;
			  <button type="button" onclick="$('.busqueda').val(''); javascript:buscar('frmListado')" class="btn btn-secondary btn-sm">Limpiar campos</button>
			 </div>        
			</div>
		   </form>			
		  </div>
		</div>
	  </div>  
	  @include('custom_pagination', ['expedientes' => $expedientes,'flag' => 'DE'])
	  <table class="table table-striped table-hover table-responsive caption-top">
	  	<caption>Listado de Expedientes &laquo;{!! 'Mostrando :' !!}
                    @if ($expedientes->firstItem())
                        <span class="font-medium">{{ $expedientes->firstItem() }}</span>
                        {!! __('al') !!}
                        <span class="font-medium">{{ $expedientes->lastItem() }}</span>
                    @else
                        {{ $expedientes->count() }}
                    @endif
                    {!! __('de') !!}
                    <span class="font-medium">{{ $expedientes->total() }}</span>
                    {!! __('resultados') !!}&raquo;
	  	</caption>    
	  	<thead class="table-light">
		  <tr>
			<!-- <th scope="col">ID</th> -->
			<th scope="col">Fecha inicio de carpeta</th>
			<th scope="col">Fecha de los hechos</th>
			<!-- <th scope="col">Fecha de registro</th> -->
			<th scope="col">Expediente</th>
			<th scope="col">N.U.C.</th>
			<th scope="col">Causa(s)</th>
			<th scope="col">Víctima(s)</th>
			<th scope="col">Delito(s)</th>
			<th scope="col">Imputado(s)</th>
			<th scope="col">Acciones</th>
		  </tr>
		</thead>
		<tbody>			
  		 @foreach($expedientes as $item)
		  <tr>
			{{--<th scope="row">{{$item->idExpediente}}</th>--}}
			<td>{{$item->FECHA_INICIO_CARPETA}}</td>
			<td>{{$item->FECHA_HECHOS}}</td>
			{{--<td>{{$item->created_at}}</td>--}}
			<td>{{$item->NO_EXPEDIENTE}}</td>
			<td>{{$item->NUC_COMPLETA}}</td>
			<td>{{$item->causas}}</td>
			<td>{{$item->victimas}}</td>
			<td>{{$item->delitos}}</td>
			<td>{{$item->imputados}}</td>
			<td>
			  <a class="btn btn-outline-primary btn-sm" 
			  onclick="javascript:parent.location.href='{{ route("dash",[$item->carpeta,$item->idExpediente]) }}'";
			   ref="#" role="button">Ver</a>
			  <!-- <a class="btn btn-outline-danger btn-sm" href="#" role="button">Eliminar</a> -->
			</td>		  	
		  </tr>
		 @endforeach
		</tbody>
	  </table>
 @stop 
 @section('indexLICC')
	  <div class="accordion" id="accordionFiltrosExpedientesCC">
		<div class="accordion-item">
		  <h2 class="accordion-header" id="panelsFiltrosExpedientesCC">
			<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOneExpedientesCC" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneExpedientesCC">
			  Filtros
			</button>
		  </h2>
		  <div id="panelsStayOpen-collapseOneExpedientesCC" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosExpedientesCC">
	       <form method='post' id="frmListadoCC" action="{{ route('listado') }}" enctype="multipart/form-data">
	        @csrf
			<div class="accordion-body row">
			 <input type="hidden" name="tipo" value="cc">
			 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="id_expediente" class="form-label">ID de Expediente:</label>
			  <input type="text" class="form-control busqueda" name="id_expediente" id="id_expediente" placeholder="">
			 </div> -->
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="no_expediente" class="form-label">Número de Expediente:</label>
			  <input type="text" class="form-control busqueda" name="no_expediente" id="no_expediente" placeholder="">
			 </div>
					 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameDel" class="form-label">Nombre del delito:</label>
					  <input type="text" class="form-control busqueda" name="nameDel" id="nameDel">
					 </div> -->
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameImp" class="form-label">Nombre del imputado:</label>
					  <input type="text" class="form-control busqueda" name="nameImp" id="nameImp">
					 </div>
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameVic" class="form-label">Nombre de la víctima:</label>
					  <input type="text" class="form-control busqueda" name="nameVic" id="nameVic">
					 </div>
			 <div class="col-12"></div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6">
			  <label for="fechaInicio" class="form-label">Fecha de inicio de carpeta:</label>
			  <div class="input-group">
				<label for="fechaInicio" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaInicio" id="fechaInicio">			  
				<label for="fechaFin" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaFin" id="fechaFin">
			  </div>
			 </div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6 d-none">
			  <label for="fechaRegistrosD" class="form-label">Fecha de registro:</label>
			  <div class="input-group">
				<label for="fechaRegistrosD" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaRegistrosD" id="fechaRegistrosD">
				<label for="fechaRegistrosH" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaRegistrosH" id="fechaRegistrosH">
			  </div>
			 </div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6">
			  <label for="fechaHechosD" class="form-label">Fecha de los hechos:</label>
			  <div class="input-group">
				<label for="fechaHechosD" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaHechosD" id="fechaHechosD">
				<label for="fechaHechosH" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaHechosH" id="fechaHechosH">
			  </div>
			 </div>
			 
			 <div class="d-flex align-items-end mb-3 col-sm-12 col-md-6">
			  <input type="hidden" name="filtroListado" id="filtroListado"> 
			  <button type="button" onclick="javascript:buscar('frmListadoCC')" class="btn btn-primary btn-sm">Buscar</button>
			  &nbsp;&nbsp;
			  <button type="button" onclick="$('.busqueda').val(''); javascript:buscar('frmListadoCC')" class="btn btn-secondary btn-sm">Limpiar campos</button>
			 </div>        
			</div>
		   </form>			
		  </div>
		</div>
	  </div>	  
	@include('custom_pagination', ['expedientes' => $expedientesCC,'flag' => 'CC'])
	  <table class="table table-striped table-hover table-responsive caption-top">
	  	<caption>Listado de Expedientes Carpeta de conducción &laquo;{!! 'Mostrando :' !!}
                    @if ($expedientesCC->firstItem())
                        <span class="font-medium">{{ $expedientesCC->firstItem() }}</span>
                        {!! __('al') !!}
                        <span class="font-medium">{{ $expedientesCC->lastItem() }}</span>
                    @else
                        {{ $expedientesCC->count() }}
                    @endif
                    {!! __('de') !!}
                    <span class="font-medium">{{ $expedientesCC->total() }}</span>
                    {!! __('resultados') !!}&raquo;
        </caption>    
	  	<thead class="table-light">
		  <tr>
			<!-- <th scope="col">ID</th> -->
			<th scope="col">Fecha inicio de carpeta</th>
			<th scope="col">Fecha de los hechos</th>
			<!-- <th scope="col">Fecha de registro</th> -->
			<th scope="col">Expediente</th>
			<th scope="col">Víctima(s)</th>
			<th scope="col">Delito(s)</th>
			<th scope="col">Imputado(s)</th>
			<th scope="col">Acciones</th>
		  </tr>
		</thead>
		<tbody>
  		 @foreach($expedientesCC as $item)
		  <tr>
			{{--<th scope="row">{{$item->idExpediente}}</th>--}}
			<td>{{$item->FECHA_INICIO_CARPETA}}</td>
			<td>{{$item->FECHA_HECHOS}}</td>
			{{--<td>{{$item->created_at}}</td>--}}
			<td>{{$item->NO_EXPEDIENTE}}</td>
			<td>{{$item->victimas}}</td>
			<td>{{$item->delitos}}</td>
			<td>{{$item->imputados}}</td>
			<td>
			  <a class="btn btn-outline-primary btn-sm" 
			  onclick="javascript:parent.location.href='{{ route("dash",[$item->carpeta,$item->idExpediente]) }}'";
			   ref="#" role="button">Ver</a>
			  <!-- <a class="btn btn-outline-danger btn-sm" href="#" role="button">Eliminar</a> -->
			</td>		  	
		  </tr>
		 @endforeach
		</tbody>
	  </table>
 @stop 
 @section('indexLIND')
	  <div class="accordion" id="accordionFiltrosExpedientesND">
		<div class="accordion-item">
		  <h2 class="accordion-header" id="panelsFiltrosExpedientesND">
			<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOneExpedientesND" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneExpedientesND">
			  Filtros
			</button>
		  </h2>
		  <div id="panelsStayOpen-collapseOneExpedientesND" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosExpedientesND">
	       <form method='post' id="frmListadoND" action="{{ route('listado') }}" enctype="multipart/form-data">
	        @csrf
			<div class="accordion-body row">
			 <input type="hidden" name="tipo" value="nd">
			 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="id_expediente" class="form-label">ID de Expediente:</label>
			  <input type="text" class="form-control busqueda" name="id_expediente" id="id_expediente" placeholder="">
			 </div> -->
			 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
			  <label for="no_expediente" class="form-label">Número de Expediente:</label>
			  <input type="text" class="form-control busqueda" name="no_expediente" id="no_expediente" placeholder="">
			 </div>
					 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameDel" class="form-label">Nombre del delito:</label>
					  <input type="text" class="form-control busqueda" name="nameDel" id="nameDel">
					 </div> -->
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameVic" class="form-label">Nombre de la víctima:</label>
					  <input type="text" class="form-control busqueda" name="nameVic" id="nameVic">
					 </div>
			 <div class="col-12"></div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6">
			  <label for="fechaInicio" class="form-label">Fecha de inicio de carpeta:</label>
			  <div class="input-group">
				<label for="fechaInicio" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaInicio" id="fechaInicio">			  
				<label for="fechaFin" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaFin" id="fechaFin">
			  </div>
			 </div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6 d-none">
			  <label for="fechaRegistrosD" class="form-label">Fecha de registro:</label>
			  <div class="input-group">
				<label for="fechaRegistrosD" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaRegistrosD" id="fechaRegistrosD">
				<label for="fechaRegistrosH" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaRegistrosH" id="fechaRegistrosH">
			  </div>
			 </div>
			 <div class="mb-3 col-sm-12 col-md-12 col-lg-6">
			  <label for="fechaHechosD" class="form-label">Fecha de los hechos:</label>
			  <div class="input-group">
				<label for="fechaHechosD" class="input-group-text">Desde:</label>
				<input type="date" class="form-control busqueda" name="fechaHechosD" id="fechaHechosD">
				<label for="fechaHechosH" class="input-group-text">Hasta:</label>
				<input type="date" class="form-control busqueda" name="fechaHechosH" id="fechaHechosH">
			  </div>
			 </div>
			 
			 <div class="d-flex align-items-end mb-3 col-sm-12 col-md-6">
			  <input type="hidden" name="filtroListado" id="filtroListado"> 
			  <button type="button" onclick="javascript:buscar('frmListadoND')" class="btn btn-primary btn-sm">Buscar</button>
			  &nbsp;&nbsp;
			  <button type="button" onclick="$('.busqueda').val(''); javascript:buscar('frmListadoND')" class="btn btn-secondary btn-sm">Limpiar campos</button>
			 </div>        
			</div>
		   </form>			
		  </div>
		</div>
	  </div>	  
	@include('custom_pagination', ['expedientes' => $expedientesND,'flag' => 'ND'])
	  <table class="table table-striped table-hover table-responsive caption-top">
	  	<caption>Listado de Expedientes No delictivos &laquo;{!! 'Mostrando :' !!}
                    @if ($expedientesND->firstItem())
                        <span class="font-medium">{{ $expedientesND->firstItem() }}</span>
                        {!! __('al') !!}
                        <span class="font-medium">{{ $expedientesND->lastItem() }}</span>
                    @else
                        {{ $expedientesND->count() }}
                    @endif
                    {!! __('de') !!}
                    <span class="font-medium">{{ $expedientesND->total() }}</span>
                    {!! __('resultados') !!}&raquo;
        </caption>    
	  	<thead class="table-light">
		  <tr>
			<!-- <th scope="col">ID</th> -->
			<th scope="col">Fecha inicio de carpeta</th>
			<th scope="col">Fecha de los hechos</th>
			<!-- <th scope="col">Fecha de registro</th> -->
			<th scope="col">Expediente</th>
			<th scope="col">Víctima(s)</th>
			<th scope="col">Hecho no constitutivo de delito</th>
			<th scope="col">Acciones</th>
		  </tr>
		</thead>
		<tbody>

  		 @foreach($expedientesND as $item)
		  <tr>
			{{--<th scope="row">{{$item->idExpediente}}</th>--}}
			<td>{{$item->FECHA_INICIO_CARPETA}}</td>
			<td>{{$item->FECHA_HECHOS}}</td>
			{{--<td>{{$item->created_at}}</td>--}}
			<td>{{$item->NO_EXPEDIENTE}}</td>
			<td>{{$item->victimas}}</td>
			<td>{{$item->delitos}}</td>

			<td>
			  <a class="btn btn-outline-primary btn-sm" 
			  onclick="javascript:parent.location.href='{{ route("dash",[$item->carpeta,$item->idExpediente]) }}'";
			   ref="#" role="button">Ver</a>
			  <!-- <a class="btn btn-outline-danger btn-sm" href="#" role="button">Eliminar</a> -->
			</td>		  	
		  </tr>
		 @endforeach
		</tbody>
	  </table>
 @stop 
 @section('script')                           
	<script type="text/javascript">
		function buscar(formulario)		
		{//frmListado
			var filtro='';
			//if ($("#"+formulario+" #id_expediente").val()!='') { filtro=filtro+" _c1_='"+ $("#"+formulario+" #id_expediente").val()+"' AND"}
			if ($("#"+formulario+" #no_expediente").val()!='') { filtro=filtro+" _c2_ LIKE'%"+ $("#"+formulario+" #no_expediente").val()+"%' AND"}
			if (formulario=="frmListado") {
				if ($("#"+formulario+" #nuc").val()!='') { filtro=filtro+" _c3_ LIKE'%"+ $("#"+formulario+" #nuc").val()+"%' AND"}
				if ($("#"+formulario+" #no_causa").val()!='') { filtro=filtro+" _c3cp_ LIKE'%"+ $("#"+formulario+" #no_causa").val()+"%' AND"}
			}
			if ($("#"+formulario+" #fechaInicio").val() != '') {
				filtro=filtro+" _c4_ >='"+ $("#"+formulario+" #fechaInicio").val()+" 00:00:00' AND"}
			if ($("#"+formulario+" #fechaFin").val() != '') {
				filtro=filtro+" _c5_ <='"+ $("#"+formulario+" #fechaFin").val()+" 23:59:59' AND"}

			if ($("#"+formulario+" #fechaRegistrosD").val() != '') {
				filtro=filtro+" _cFRD_ >='"+ $("#"+formulario+" #fechaRegistrosD").val()+" 00:00:00' AND"}
			if ($("#"+formulario+" #fechaRegistrosH").val() != '') {
				filtro=filtro+" _cFRH_ <='"+ $("#"+formulario+" #fechaRegistrosH").val()+" 23:59:59' AND"}

			if ($("#"+formulario+" #fechaHechosD").val() != '') {
				filtro=filtro+" _cFHD_ >='"+ $("#"+formulario+" #fechaHechosD").val()+" 00:00:00' AND"}
			if ($("#"+formulario+" #fechaHechosH").val() != '') {
				filtro=filtro+" _cFHH_ <='"+ $("#"+formulario+" #fechaHechosH").val()+" 23:59:59' AND"}

			//if ($("#"+formulario+" #nameDel").val() != '') { filtro=filtro+" _c6_"+ $("#"+formulario+" #nameDel").val()+"_LE_ AND"}
			if ($("#"+formulario+" #nameVic").val() != '') { filtro=filtro+" _c8_"+ $("#"+formulario+" #nameVic").val()+"_LE_ AND"}

			if (formulario!="frmListadoND") {
			if ($("#"+formulario+" #nameImp").val() != '') { filtro=filtro+" _c7_"+ $("#"+formulario+" #nameImp").val()+"_LE_ AND"}
			}
				filtro=filtro.slice(0, -4);
			$("#"+formulario+" #filtroListado").val(filtro);
			$("#"+formulario).submit();
		}
	@if($post)

	$(function(){
	 $("#panelsListadoExp{{$tipo}}Heading").children().click();
	});
	@endif
  	@if(null !== request('page') && null === request('CC') && null === request('ND'))
	 $(function(){
	  $("#panelsListadoExpHeading").children().click();
	 });
	@endif
  	@if(null !== request('CC'))
	 $(function(){
	  $("#panelsListadoExpCCHeading").children().click();
	 });
	@endif
  	@if(null !== request('ND'))
	 $(function(){
	  $("#panelsListadoExpNDHeading").children().click();
	 });
	@endif		
	</script>
 @stop

 