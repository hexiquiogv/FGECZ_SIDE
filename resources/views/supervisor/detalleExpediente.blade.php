@extends('layouts.dashboard')

@section('navBarTitle')
Expediente {{$datos->NO_EXPEDIENTE??''}}
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
 @section('collapsedDS','')
 @section('activeDS','active')
 @section('indexDS')

	<div class="row">
		<div class="col-md-8">
			<div>
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayFechaI" value="{{$datos->FECHA_INICIO??''}}">			  
				  <label for="displayFechaI">Fecha de Inicio:</label>			  
				</form>
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayFechaH" value="{{$datos->FECHA_HECHOS??''}}">
				  <label for="displayFechaH">Fecha de los Hechos:</label>		  
				</form>
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayMP_NAME" value="{{$datos->MP_NAME??''}}">
				  <label for="displayMP_NAME">Agente del M.P. responsable:</label>
		  		</form>
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayMP_UNIDAD" value="{{$datos->MP_UNIDAD??''}}">
				  <label for="displayMP_UNIDAD">Unidad:</label>
		  		</form>
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayMP_DELEGACION" value="{{$datos->MP_DELEGACION??''}}">
				  <label for="displayMP_DELEGACION">Delegación:</label>
		  		</form>
				@if($tabla=='de')
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayNUC" value="{{$datos->NUC_COMPLETA??''}}">
				  <label for="displayNUC">No. de NUC:</label>				
		  		</form>
				@endif		  	
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayNO_EXPEDIENTE" value="{{$datos->NO_EXPEDIENTE??''}}">
				  <label for="displayNO_EXPEDIENTE">No. de expediente:</label>				
		  		</form>
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displaydelito" value="{{$delitosGrl->delito??''}}">
				  <label for="displaydelito">Delito general:</label>				
		  		</form>
				@if($tabla!='nd')
				<form class="form-floating mb-2">
				  <input type="text" readonly class="form-control" id="displayUNIDAD_QUE_RECIBE" value="{{$datos->UNIDAD_QUE_RECIBE??''}}">
				  <label for="displayUNIDAD_QUE_RECIBE">Unidad que recibe:</label>				
		  		</form>
		  		@endif
				@if($tabla=='de')
				<form class="form-floating mb-3">
				  <input type="text" readonly class="form-control" id="displayDETENIDOS" value="{{$datos->DETENIDOS??'N/A'}}">
				  <label for="displayDETENIDOS">¿Con detenidos?</label>
		  		</form>
		  		@endif
  			</div>
			<div class="accordion mb-3" id="accordionFiltrosVictimas">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="panelsFiltrosVictimas">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
			      data-bs-target="#panelsStayOpen-collapseOneVictimas" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneVictimas">
			        Víctimas
			      </button>
			    </h2>
			    <div id="panelsStayOpen-collapseOneVictimas" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosVictimas">
			      <div class="accordion-body">
			        <input type="hidden" name="hdnVictimasCP" id="hdnVictimasCP">    

			          <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
			            <!-- <caption>Listado de víctimas de la causa penal</caption>     -->
			            <thead class="table-light">
			            <tr>
			              <th scope="col">#</th>
			              <th scope="col">Nombre registrado</th>
										@if($tabla=='de' || $tabla=='nd')           
			              <th scope="col">Sexo</th>
		              	@endif
		              	@if($tabla=='de')			              
			              <th scope="col">Edad al momento de los hechos</th>
			              @endif
			            </tr>
			          </thead>
			          <tbody>
			            @foreach($victimas as $victima)
			              <tr class="trI{{$victima->id}}" >
			              	<th scope="row">{{$victima->id}}</th>
			              	<td>{{$victima->Nombre}}</td>
											@if($tabla=='de' || $tabla=='nd')
			              	<td>{{$victima->Sexo}}</td>
			              	@endif
			              	@if($tabla=='de')
			              	<td>{{$victima->EDAD_HECHOS_VICTIMAS}}</td>
		              		@endif
		              	</tr>
			            @endforeach
			          </tbody>
			        </table>

			      </div>
			    </div>
			  </div>
			</div>
			@if($tabla=='de' || $tabla=='cc')
			<div class="accordion mb-3" id="accordionFiltrosImputados">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="panelsFiltrosImputados">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
			      data-bs-target="#panelsStayOpen-collapseOneImputados" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneImputados">
			        Imputados
			      </button>
			    </h2>
			    <div id="panelsStayOpen-collapseOneImputados" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosImputados">
			      <div class="accordion-body">
			        <input type="hidden" name="hdnImputadosCP" id="hdnImputadosCP">    

			          <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
			            <!-- <caption>Listado de víctimas de la causa penal</caption>     -->
			            <thead class="table-light">
			            <tr>
			              <th scope="col">#</th>
			              <th scope="col">Nombre registrado</th>
										@if($tabla=='de')
			              <th scope="col">Sexo</th>
			              <th scope="col">Edad al momento de los hechos</th>
			              @endif
			            </tr>
			          </thead>
			          <tbody>
			            @foreach($imputados as $imputado)
			              <tr class="trI{{$imputado->id}}" >
			              	<th scope="row">{{$imputado->id}}</th>
			              	<td>{{$imputado->Nombre}}</td>
            					@if($tabla=='de')
			              	<td>{{$imputado->Sexo}}</td>
			              	<td>{{$imputado->EDAD_HECHOS_IMPUTADOS}}</td>
			              	@endif
		              	</tr>
			            @endforeach
			          </tbody>
			        </table>

			      </div>
			    </div>
			  </div>
			</div>
			@endif
			<div class="accordion mb-3" id="accordionFiltrosDelitos">
			  <div class="accordion-item">
			    <h2 class="accordion-header" id="panelsFiltrosDelitos">
			      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
			      data-bs-target="#panelsStayOpen-collapseOneDelitos" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneDelitos">
			        Delitos
			      </button>
			    </h2>
			    <div id="panelsStayOpen-collapseOneDelitos" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosDelitos">
			      <div class="accordion-body">
			        <input type="hidden" name="hdnDelitosCP" id="hdnDelitosCP">    

			          <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
			            <!-- <caption>Listado de víctimas de la causa penal</caption>     -->
			            <thead class="table-light">
								    <tr>
								      <th scope="col">#</th>
				      				@if($tabla=='de' || $tabla=='cc')
								      <th scope="col">Delito</th>
								      @else
								      <th scope="col">Hecho no constitutivo de delito</th>
								      @endif
								    </tr>
			          </thead>
			          <tbody>
			            @foreach($hechos as $delito)
								    <tr>
								      <th scope="row">{{$delito->id}}</th>
								      <td>{{strtoupper($delito->Valor)}}</td>
								    </tr>
			            @endforeach
			          </tbody>
			        </table>

			      </div>
			    </div>
			  </div>
			</div>
			@if($tabla=='de')
				<div class="accordion mb-3" id="accordionFiltrosRelaciones">
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="panelsFiltrosRelaciones">
				      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
				      data-bs-target="#panelsStayOpen-collapseOneRelaciones" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneRelaciones">
				        Relación delitos-imputados-víctimas
				      </button>
				    </h2>
				    <div id="panelsStayOpen-collapseOneRelaciones" class="accordion-collapse collapse" aria-labelledby="panelsFiltrosRelaciones">
				      <div class="accordion-body">
				        <input type="hidden" name="hdnRelacionesCP" id="hdnRelacionesCP">    

				          <table class="table table-striped table-hover table-responsive caption-top" id="tbVitimasCP">
				            <!-- <caption>Listado de víctimas de la causa penal</caption>     -->
				            <thead class="table-light">
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">Delito</th>
								      <th scope="col">Imputado(s)</th>
								      <th scope="col">Víctima(s)</th>
								    </tr>
				          </thead>
				          <tbody>
				            @foreach($relaciones as $relacion)
									    <tr>
									      <th scope="row">{{$relacion->id}}</th>
									      <td>{{$relacion->delito}}</td>
									      <td>{{$relacion->imputados}}</td>      
									      <td>{{$relacion->victimas}}</td>
									    </tr>
				            @endforeach
				          </tbody>
				        </table>

				      </div>
				    </div>
				  </div>
				</div>
			@endif
		</div>
		<div class="col-md-4">
			<div class="p-3 bg-body rounded shadow">
				{{-- @if($Correcc < 1 && $Validac < 1) --}}
				@if($Validac < 1)
				 <form method='post' name="frmDetalleNO" id="frmDetalleNO" action="{{ route('correccion.super') }}" enctype="multipart/form-data">
				 	@csrf 
			    <input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
			    <input type="hidden" name="Ctrl" id="Ctrl" value="{{$tabla}}">
				  <div class="mb-3 col-12 text-center">
				    <label for="CorreccionObservaciones" class="form-label">Observaciones:</label>
				    <textarea  type="textarea" class="form-control" rows="9" name="CorreccionObservaciones" id="CorreccionObservaciones" placeholder=""></textarea>
							@if($errors->has('CorreccionObservaciones'))
								<span class="text-danger">{{ $errors->first('CorreccionObservaciones') }}</span>
							@endif			    
				  </div> 
				  <div class="d-grid py-2 text-center">
			   		<button type="submit" class="btn btn-warning btn-lg mx-2">Solicitar corrección</button>
				  </div>  
				 </form>
				 <form method='post' name="frmDetalleNO" id="frmDetalleNO" action="{{ route('validacion.super') }}" enctype="multipart/form-data">
				 	@csrf 
					<input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
					<input type="hidden" name="Ctrl" id="Ctrl" value="{{$tabla}}">
				  <div class="d-grid pt-5 text-center">
					  	<button type="submit" class="btn btn-success btn-lg mx-2">Validar</button>
				  </div>
	    	 </form>
	  	 	@else
					<div class="alert alert-info alert-dismissible fade show" id="" role="alert">
						<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
						@if($Validac > 0)
						El Expediente ya fue validado.
						@elseif($Correcc > 0)
						El Expediente está en espera de corrección.
						@endif
						<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
					</div>
	  	 	@endif
	  	 	<form method='post' name="frmDetalleNO" id="frmDetalleNO" action="{{ route('redirect.super') }}" enctype="multipart/form-data">
				 	@csrf 
					<input type="hidden" name="idExp" id="idExp" value="{{$idExp}}">
					<input type="hidden" name="Ctrl" id="Ctrl" value="{{$tabla}}">
					 <div class="d-grid pt-5 text-center">
			 			<button type="submit" class="btn btn-info btn-lg mx-2">Ver expediente completo</button>
					 </div>
		  	</form>
	 		</div>
	 		@if($Correcc > 0 && $Validac < 1)
	 		<div class="p-3 mt-3 text-center bg-body rounded shadow">
	 			<label class="form-label">Observaciones sin corrección:</label>
	 			 <ul>
	 			 	@php
			    	$vv = 1;
			    	$fecha = '';
					@endphp
		 			@foreach($CorreccDATA as $CorrDATA)
		 				@php
				    	$actual = strtoupper(\Carbon\Carbon::parse($CorrDATA->created_at)->format('Y-M-d'));				    	
						@endphp						
						@if($actual!=$fecha)
		 					<li class="text-start">{{$fecha=strtoupper(\Carbon\Carbon::parse($CorrDATA->created_at)->format('Y-M-d'));}}
	 					@endif
		 					<ul><li>{{$CorrDATA->Observaciones}}</li></ul>
		 				@if($actual!=$fecha)
		 					</li>
	 					@endif	 					
	 					@php
	 						$fecha=strtoupper(\Carbon\Carbon::parse($CorrDATA->created_at)->format('Y-M-d'));
	 						$vv++;
						@endphp
		 			@endforeach
		 		 </ul>
	 		</div>
	 		@endif
		</div>		
	</div> 	
 @stop

@section('script')                          
	<script type="text/javascript">

	</script>
 @stop

 