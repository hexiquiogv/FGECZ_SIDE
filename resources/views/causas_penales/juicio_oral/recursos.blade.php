<div class="accordion" id="accordionFiltrosRecursos_{{$imputado->id}}">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsFiltrosRecursos_{{$imputado->id}}">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" 
      data-bs-target="#panelsStayOpen-collapseOneRecursos_{{$imputado->id}}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOneRecursos_{{$imputado->id}}">
        Listado de recursos
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOneRecursos_{{$imputado->id}}" class="accordion-collapse collapse show" aria-labelledby="panelsFiltrosRecursos_{{$imputado->id}}">
      <div class="accordion-body row">
	      <div class="mb-3 col-sm-12 input-group">
          <label for="causa_H_fecha_recurso" class="input-group-text">Fecha:</label>
          <input type="date" class="form-control imp{{$imputado->id}}" name="causa_H_fecha_recurso" id="causa_H_fecha_recurso">
          <label for="causa_H_tipo_de_recurso" class="input-group-text">Tipo:</label>
          <select class="form-select imp{{$imputado->id}}" name="causa_H_tipo_de_recurso" id="causa_H_tipo_de_recurso">
            <option value="-1">Seleccione una opción</option>
            @foreach ($tipoRecurso as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach              
         	</select>
          <label for="causa_H_resolucion_del_recurso" class="input-group-text">Resolución:</label>
<!--           <input type="text" class="form-control imp{{$imputado->id}}" name="causa_H_resolucion_del_recurso" 
          	id="causa_H_resolucion_del_recurso" maxlength="255"> -->
         <select class="form-select imp{{$imputado->id}}" name="causa_H_resolucion_del_recurso" id="causa_H_resolucion_del_recurso">
            <option value="-1">Seleccione una opción</option>
            @foreach ($Resol as $item)      
              <option value="{{ $item->id }}">{{$item->Valor}}</option>      
            @endforeach              
         	</select>          	
	        <button type="button" class="btn btn-primary"onclick="javascript:addRecurso({{$imputado->id}})">
	          Agregar recurso
	        </button>
	      </div> 
	      <input type="hidden" name="hdnRecursos{{$imputado->id}}" id="hdnRecursos{{$imputado->id}}">
	      <table id="recursos{{$imputado->id}}" class="col-12 table table-striped table-hover table-responsive caption-top">
	          <caption></caption>    
	          <thead class="table-light">
	          <tr>
	            <th scope="col">Fecha de recurso</th>
	            <th scope="col">Tipo de recurso</th>
	            <th scope="col">Resolución del recurso</th>
	            <th scope="col">Eliminar</th>
	          </tr>
	        </thead>
	        <tbody> 

	         @foreach ($recursos[$imputado->id] as $recurso)
						<tr class="tr{{$imputado->id}}_{{$recurso->id}}">
							<td>{{$recurso->FECHA_RECURSO}}</td>
							<td>{{$recurso->RECURSO}}</td>
							<td>{{$recurso->RESOLUCION}}</td>
							<td>
								<button type="button" title="Eliminar recurso" class="btn btn-danger" 
								onclick="eliminarRecurso('{{$imputado->id}}','{{$recurso->id}}',1)">×</button>
							</td>
						</tr>
					 @endforeach
	        </tbody>
	      </table>    
      </div>
    </div>
  </div>
</div>