@if($idExp=='30')
 <div class="alert alert-warning" id="">
	<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#exclamation-triangle-fill"/></svg>
	Deben registrarse los datos del expediente para generar una causa penal
 </div> 	
@else
	<!-- @include("causas_penales.listado.accordion_filtros") -->
	@include("causas_penales.listado.table")
	@include("causas_penales.listado.create")
@endif