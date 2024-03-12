@if(Session::get('43iqd89h'))
	{{Session::put('43i','1')}}
    <div class="alert alert-danger alert-dismissible fade show" id="" role="alert">      
      	Relación del delito - imputado - víctima ya existe
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  
@include("datos_expedientes.relacion.accordion_filtros")
@include("datos_expedientes.relacion.table")
@include("datos_expedientes.relacion.create")
