@extends('layouts.dashboard')

@section('navBarTitle')
Expedientes de Supervisión de {{Auth::User()->name}}
 @stop
@section('navBarListado') 
	<a class="dropdown-item" href='{{ route("listado.super") }}'>Inicio</a>
	<div class="dropdown-divider"></div>
	@if(Auth::User()->TipoUsuario!=2)
		<a class="dropdown-item" href='{{ route("estadistica.super") }}'>Apartado estadístico</a>
		<div class="dropdown-divider"></div>
	@endif
 @stop
@section('navBarSalir') 
	<a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
 @stop
 @section('collapsedNT','')
 @section('activeNT','active')
 @section('collapsedLS','collapsed')
 @section('activeLS','')
 @section('indexNT')
	<div class="row">
		<div class="col-md-3">
			@include("inicio.total_registro") 
		</div>
		<div class="col-md-9">
			@include("inicio.notificaciones") 
		</div>
	</div> 	
 @stop
 @section('indexLS')
	<div class="col pt-4">

	  <div class="accordion" id="accordionFiltrosExpedientes">
			<div class="accordion-item">
			  <h2 class="accordion-header" id="panelsFiltrosExpedientes">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOneExpedientes" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneExpedientes">
				  Filtros
				</button>
			  </h2>
			  <div id="panelsStayOpen-collapseOneExpedientes" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosExpedientes">
         <form method='post' id="frmListado" action="{{ route('listado.super') }}" enctype="multipart/form-data">
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
					<!--<div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="id_user" class="form-label">Id de usuario:</label>
					  <input type="text" class="form-control busqueda" name="id_user" id="id_user" placeholder="">
					 </div> -->
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameUser" class="form-label">Nombre de usuario:</label>
					  <input type="text" class="form-control busqueda" name="nameUser" id="nameUser">
					 </div>
					 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameDel" class="form-label">Nombre del delito:</label>
					  <input type="text" class="form-control busqueda" name="nameDel" id="nameDel">
					 </div> -->
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
				        <label for="delegacionMP" class="form-label">Delegación a la que pertenece el M.P.:</label>
				        <select class="form-select busqueda" name="delegacionMP" id="delegacionMP">
				          <option value="0">Seleccione una opción</option>
				          @foreach($delegaciones as $item)
				          <option value="{{$item->id}}">{{$item->Valor}}</option>
				          @endforeach				          
				       </select>
					 </div>
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="unidadMP" class="form-label">Unidad a la que pertenece el M.P.:</label>
					  <input type="text" class="form-control busqueda" name="UnidadMP" id="unidadMP">
					 </div>
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
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
				        <label for="estatusExp" class="form-label">Estatus:</label>
				        <select class="form-select busqueda" name="estatusExp" id="estatusExp">
				          <option value="0">Seleccione una opción</option>
				          <option value="1">Validado</option>
				          <option value="2">No Validado</option>
				          <option value="3">Pendiente corrección</option>
				          <option value="4">Plazo de investigación por vencer</option>
				       </select>
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
		  <caption>Carpetas iniciadas &laquo;{!! 'Mostrando :' !!}
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
				<!-- <th scope="col">ID</th> 
				<th scope="col">Fecha de captura</th>
				<th scope="col">Úlitma modificación</th>-->
				<th scope="col">Fecha inicio de carpeta</th>
				<th scope="col">Fecha de los hechos</th>
				<!-- <th scope="col">Fecha de registro</th> -->
				<th scope="col">N.U.C.</th>
				<th scope="col">No. Expediente</th>
				<th scope="col">Causa(s)</th>
				<th scope="col">Agente M.P.</th>
				<th scope="col">Unidad a la que pertenece el M.P.</th>
				<th scope="col">Delegación a la que pertenece el M.P.</th>
				<th scope="col">Persona que captura</th>
				<th scope="col">Delitos</th>
				<th scope="col">Personas imputadas</th>
				<th scope="col">Personas víctimas</th>
				<th scope="col">Estatus</th>
				<th scope="col">Acciones</th>
		  </tr>
		</thead>
		<tbody>
		 @foreach($expedientes as $item)
		  <tr>
				{{--<th scope="row">{{$item->idExpediente}}</th>
				<td>{{$item->created_at}}</td>
				<td>{{$item->updated_at}}</td>--}}
				<td>{{$item->FECHA_INICIO_CARPETA}}</td>
				<td>{{$item->FECHA_HECHOS}}</td>
				{{--<td>{{$item->created_at}}</td>--}}
				<td>{{$item->NUC}}</td>
				<td>{{$item->NO_EXPEDIENTE}}</td>
				<td>{{$item->causas}}</td>
				<td>{{$item->RESPONSABLE}}</td>
				<td>{{str_replace("_"," ",$item->UNIDAD)}}</td>
				<td>{{$item->MP_DELEGACION}}</td>
				<td>{{$item->name}}</td>
				<td>{{$item->delitos}}</td>
				<td>{{$item->imputados}}</td>
				<td>{{$item->victimas}}</td>
				<td>
					@if($item->Validacion)
					<span class="badge bg-success">Validado</span>
					@endif
					@if($item->Correccion)
					<span class="badge bg-warning">Pte. corrección</span>
					@endif
					@if($item->Vigencia)
					<span class="badge bg-danger">Por vencer</span>
					@endif															
				</td>
				<td>
				  <a class="btn btn-outline-primary btn-sm" 
				  onclick="reasignar(1,'{{$item->idExpediente}}')" href="#" role="button">Reasignar</a>
				  <a class="btn btn-outline-info btn-sm" href='{{ route("detalle.super",["de",$item->idExpediente]) }}' role="button">Detalles</a>
				</td>		  	
		  </tr>
		 @endforeach
		</tbody>
	  </table>
	</div>  

 @stop 
 @section('indexLSCC')
	<div class="col pt-4">

	  <div class="accordion" id="accordionFiltrosExpedientesCC">
			<div class="accordion-item">
			  <h2 class="accordion-header" id="panelsFiltrosExpedientesCC">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOneExpedientesCC" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneExpedientesCC">
				  Filtros
				</button>
			  </h2>
			  <div id="panelsStayOpen-collapseOneExpedientesCC" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosExpedientesCC">
	       <form method='post' id="frmListadoCC" action="{{ route('listado.super') }}" enctype="multipart/form-data">
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
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameUser" class="form-label">Nombre de usuario:</label>
					  <input type="text" class="form-control busqueda" name="nameUser" id="nameUser" placeholder="">
					 </div>
					 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameDel" class="form-label">Nombre del delito:</label>
					  <input type="text" class="form-control busqueda" name="nameDel" id="nameDel">
					 </div> -->
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
				        <label for="delegacionMP" class="form-label">Delegación a la que pertenece el M.P.:</label>
				        <select class="form-select busqueda" name="delegacionMP" id="delegacionMP">
				          <option value="0">Seleccione una opción</option>
				          @foreach($delegaciones as $item)
				          <option value="{{$item->id}}">{{$item->Valor}}</option>
				          @endforeach				          
				       </select>
					 </div>
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="unidadMP" class="form-label">Unidad a la que pertenece el M.P.:</label>
					  <input type="text" class="form-control busqueda" name="UnidadMP" id="unidadMP">
					 </div>					 
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
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
				        <label for="estatusExp" class="form-label">Estatus:</label>
				        <select class="form-select busqueda" name="estatusExp" id="estatusExp">
				          <option value="0">Seleccione una opción</option>
				          <option value="1">Validado</option>
				          <option value="2">No Validado</option>
				          <option value="3">Pendiente corrección</option>
				       	</select>
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
		  <caption>Conducción &laquo;{!! 'Mostrando :' !!}
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
				<!-- <th scope="col">ID</th> 
				<th scope="col">Fecha de captura</th>
				<th scope="col">Úlitma modificación</th>-->
				<th scope="col">Fecha inicio de carpeta</th>
				<th scope="col">Fecha de los hechos</th>
				<!-- <th scope="col">Fecha de registro</th> -->
				<th scope="col">No. Expediente</th>
				<th scope="col">Agente M.P.</th>
				<th scope="col">Unidad a la que pertenece el M.P.</th>
				<th scope="col">Delegación a la que pertenece el M.P.</th>
				<th scope="col">Persona que captura</th>
				<th scope="col">Delitos</th>
				<th scope="col">Personas imputadas</th>
				<th scope="col">Personas víctimas</th>
				<th scope="col">Estatus</th>				
				<th scope="col">Acciones</th>
		  </tr>
		</thead>
		<tbody>
		 @foreach($expedientesCC as $item)
		  <tr>
				{{--<th scope="row">{{$item->idExpediente}}</th>
				<td>{{$item->created_at}}</td>
				<td>{{$item->updated_at}}</td>--}}
				<td>{{$item->FECHA_INICIO_CARPETA}}</td>
				<td>{{$item->FECHA_HECHOS}}</td>
				{{--<td>{{$item->created_at}}</td>--}}
				<td>{{$item->NO_EXPEDIENTE_CONDUCCION}}</td>
				<td>{{$item->RESPONSABLE}}</td>
				<td>{{str_replace("_"," ",$item->UNIDAD)}}</td>
				<td>{{$item->MP_DELEGACION}}</td>
				<td>{{$item->name}}</td>
				<td>{{$item->delitos}}</td>
				<td>{{$item->imputados}}</td>
				<td>{{$item->victimas}}</td>
				<td>
					@if($item->Validacion)
					<span class="badge bg-success">Validado</span>
					@endif
					@if($item->Correccion)
					<span class="badge bg-warning">Pte. corrección</span>
					@endif															
				</td>				
				<td>
			  <a class="btn btn-outline-primary btn-sm" 
			  onclick="reasignar(3,'{{$item->idExpediente}}')" href="#" role="button">Reasignar</a>
			  <a class="btn btn-outline-info btn-sm" href='{{ route("detalle.super",["cc",$item->idExpediente]) }}' role="button">Detalles</a>
				</td>		  	
		  </tr>
		 @endforeach
		</tbody>
	  </table>
	</div>  

 @stop 
 @section('indexLSND')
	<div class="col pt-4">

	  <div class="accordion" id="accordionFiltrosExpedientesND">
			<div class="accordion-item">
			  <h2 class="accordion-header" id="panelsFiltrosExpedientesND">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOneExpedientesND" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneExpedientesND">
				  Filtros
				</button>
			  </h2>
			  <div id="panelsStayOpen-collapseOneExpedientesND" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosExpedientesND">
         <form method='post' id="frmListadoND" action="{{ route('listado.super') }}" enctype="multipart/form-data">
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
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameUser" class="form-label">Nombre de usuario:</label>
					  <input type="text" class="form-control busqueda" name="nameUser" id="nameUser" placeholder="">
					 </div>
					 <!-- <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="nameDel" class="form-label">Nombre del delito:</label>
					  <input type="text" class="form-control busqueda" name="nameDel" id="nameDel">
					 </div> -->
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
				        <label for="delegacionMP" class="form-label">Delegación a la que pertenece el M.P.:</label>
				        <select class="form-select busqueda" name="delegacionMP" id="delegacionMP">
				          <option value="0">Seleccione una opción</option>
				          @foreach($delegaciones as $item)
				          <option value="{{$item->id}}">{{$item->Valor}}</option>
				          @endforeach				          
				       </select>
					 </div>
					 <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
					  <label for="unidadMP" class="form-label">Unidad a la que pertenece el M.P.:</label>
					  <input type="text" class="form-control busqueda" name="UnidadMP" id="unidadMP">
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
					 	<div class="mb-3 col-sm-12 col-md-6 col-lg-3">
				        <label for="estatusExp" class="form-label">Estatus:</label>
				        <select class="form-select busqueda" name="estatusExp" id="estatusExp">
				          <option value="0">Seleccione una opción</option>
				          <option value="1">Validado</option>
				          <option value="2">No Validado</option>
				          <option value="3">Pendiente corrección</option>
				       	</select>
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
		  <caption>Hechos no delictivos &laquo;{!! 'Mostrando :' !!}
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
				<!-- <th scope="col">ID</th> 
				<th scope="col">Fecha de captura</th>
				<th scope="col">Úlitma modificación</th>-->
				<th scope="col">Fecha inicio de carpeta</th>
				<th scope="col">Fecha de los hechos</th>
				<!-- <th scope="col">Fecha de registro</th> -->
				<th scope="col">No. Expediente</th>
				<th scope="col">Agente M.P.</th>
				<th scope="col">Unidad a la que pertenece el M.P.</th>
				<th scope="col">Delegación a la que pertenece el M.P.</th>
				<th scope="col">Persona que captura</th>
				<th scope="col">Hecho no constitutivo de delito</th>
				<th scope="col">Personas víctimas</th>
				<th scope="col">Estatus</th>
				<th scope="col">Acciones</th>
		  </tr>
		</thead>
		<tbody>
		 @foreach($expedientesND as $item)
		  <tr>
				{{--<th scope="row">{{$item->idExpediente}}</th>
				<td>{{$item->created_at}}</td>
				<td>{{$item->updated_at}}</td>--}}
				<td>{{$item->FECHA_INICIO_CARPETA}}</td>
				<td>{{$item->FECHA_HECHOS}}</td>
				{{--<td>{{$item->created_at}}</td>--}}
				<td>{{$item->NO_EXPEDIENTE}}</td>
				<td>{{$item->RESPONSABLE}}</td>
				<td>{{str_replace("_"," ",$item->UNIDAD)}}</td>
				<td>{{$item->MP_DELEGACION}}</td>
				<td>{{$item->name}}</td>
				<td>{{$item->delitos}}</td>
				<td>{{$item->victimas}}</td>
				<td>
					@if($item->Validacion)
					<span class="badge bg-success">Validado</span>
					@endif
					@if($item->Correccion)
					<span class="badge bg-warning">Pte. corrección</span>
					@endif														
				</td>				
				<td>
				  <a class="btn btn-outline-primary btn-sm" 
				  onclick="reasignar(2,'{{$item->idExpediente}}')" href="#" role="button">Reasignar</a>
				  <a class="btn btn-outline-info btn-sm" href='{{ route("detalle.super",["nd",$item->idExpediente]) }}' role="button">Detalles</a>
				</td>		  	
		  </tr>
		 @endforeach
		</tbody>
	  </table>
	</div>  

 @stop 

	<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="btnReasignar" 
data-bs-target="#reasignarExpedienteForm">
  Reasignar Expediente
</button>
<!-- Modal -->

	<div class="modal fade" id="reasignarExpedienteForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reasignarExpedienteFormLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-scrollable modal-sm"><!--modal-dialog-scrollable modal-lg modal-fullscreen-->
	    <div class="modal-content">
		  	
	      <form method='post' id="frmReasignar" action="{{ route('reasignarExp') }}" enctype="multipart/form-data">
	            @csrf
	       <div class="modal-header">
	        <h1 class="modal-title fs-5" id="reasignarExpedienteFormLabel">Reasignar Expediente</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	       </div>
	       <div class="modal-body">
					<div class="mb-1 col-sm-12 text-center">
						<label for="usuarioRe" class="form-label">¿A cuál usuario se debe reasignar el expediente?</label>
						<input type="hidden" name="expRe" id="expRe">
						<input type="hidden" name="tblRe" id="tblRe">
						<select class="form-select" name="usuarioRe" id="usuarioRe">
						<option value="0" selected>Seleccione una opción</option>
						 @foreach($usuarios as $user)
							<option value="{{ $user->id }}">{{$user->name}} : {{$user->email}}</option>
						 @endforeach 
						</select>
					</div>
					<div class="alert alert-warning" id="alerta" style="display:none;"></div>
	       </div>
	       <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="button" onclick="ReasignarOK()" class="btn btn-primary">Reasignar</button>
	       </div>
	      </form>
	    </div>
	  </div>
	</div>
@section('script')                          
	<script type="text/javascript">
		function buscar(formulario)		
		{
			var filtro='';
			//if ($("#"+formulario+" #id_expediente").val() != '') { filtro=filtro+" _c1_='"+ $("#"+formulario+" #id_expediente").val()+"' AND"}
			if ($("#"+formulario+" #no_expediente").val() != '') { filtro=filtro+" _c2_ LIKE'%"+ $("#"+formulario+" #no_expediente").val()+"%' AND"}
			if ($("#"+formulario+" #nameUser").val() != '') { filtro=filtro+" _c5_ LIKE '%"+ $("#"+formulario+" #nameUser").val()+"%' AND"}

			if ($("#"+formulario+" #fechaInicio").val() != '') {
				filtro=filtro+" _c6_ >='"+ $("#"+formulario+" #fechaInicio").val()+" 00:00:00' AND"}
			if ($("#"+formulario+" #fechaFin").val() != '') {
				filtro=filtro+" _c7_ <='"+ $("#"+formulario+" #fechaFin").val()+" 23:59:59' AND"}
			if ($("#"+formulario+" #estatusExp").val() > 0) {
					filtro=filtro+" _c8"+$("#"+formulario+" #estatusExp").val()+"_='1' AND";
			}
			if ($("#"+formulario+" #fechaRegistrosD").val() != '') {
				filtro=filtro+" _cFRD_ >='"+ $("#"+formulario+" #fechaRegistrosD").val()+" 00:00:00' AND"}
			if ($("#"+formulario+" #fechaRegistrosH").val() != '') {
				filtro=filtro+" _cFRH_ <='"+ $("#"+formulario+" #fechaRegistrosH").val()+" 23:59:59' AND"}

			if ($("#"+formulario+" #fechaHechosD").val() != '') {
				filtro=filtro+" _cFHD_ >='"+ $("#"+formulario+" #fechaHechosD").val()+" 00:00:00' AND"}
			if ($("#"+formulario+" #fechaHechosH").val() != '') {
				filtro=filtro+" _cFHH_ <='"+ $("#"+formulario+" #fechaHechosH").val()+" 23:59:59' AND"}
			
			//if ($("#"+formulario+" #nameDel").val() != '') { filtro=filtro+" _c9_"+ $("#"+formulario+" #nameDel").val()+"_LE_ AND"}
			
			if ($("#"+formulario+" #delegacionMP").val() > 0) 
				{ filtro=filtro+" _c12_ ="+ $("#"+formulario+" #delegacionMP").val()+" AND"}
			if ($("#"+formulario+" #unidadMP").val() != '') 
				{ filtro=filtro+" _c13_ LIKE'%"+ $("#"+formulario+" #unidadMP").val()+"%' AND"}

			if ($("#"+formulario+" #nameVic").val() != '') 
				{ filtro=filtro+" _c11_"+ $("#"+formulario+" #nameVic").val()+"_LE_ AND"}

			if (formulario!="frmListadoND") {
			if ($("#"+formulario+" #nameImp").val() != '') { filtro=filtro+" _c10_"+ $("#"+formulario+" #nameImp").val()+"_LE_ AND"}
			}
			if (formulario=="frmListado") {
				if ($("#"+formulario+" #nuc").val()!='') { filtro=filtro+" _c3_ LIKE '%"+ $("#"+formulario+" #nuc").val()+"%' AND"}
				if ($("#"+formulario+" #no_causa").val()!='') { filtro=filtro+" _c3cp_ LIKE '%"+ $("#"+formulario+" #no_causa").val()+"%' AND"}
			}				
				filtro=filtro.slice(0, -4);
			$("#"+formulario+" #filtroListado").val(filtro);
			$("#"+formulario).submit();
		}
		@if($post)

			$(function(){
			 $("#panelsListadoSup{{$tipo}}Heading").children().click();
			});
		@endif
@if(null !== request('page') && null === request('CC') && null === request('ND'))
	 $(function(){
	  $("#panelsListadoSupHeading").children().click();
	 });
	@endif
  	@if(null !== request('CC'))
	 $(function(){
	  $("#panelsListadoSupCCHeading").children().click();
	 });
	@endif
  	@if(null !== request('ND'))
	 $(function(){
	  $("#panelsListadoSupNDHeading").children().click();
	 });
	@endif	
		function reasignar(t,exp)
		{
			$("#expRe").val(exp);
			$("#tblRe").val(t);
			$("#btnReasignar").click();
		}

		function ReasignarOK()
		{
			if($("#usuarioRe :selected").val()!='0')
			{
				$("#frmReasignar").submit();
			}
			else
			{
				$("#alerta").show();
				$("#alerta").text('Es necesario elegir un usuario')
			}
		}
	</script>
 @stop

 